<?php

namespace App\DB\MySQL\Models;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Methods\AbstractMethods;
use PDO;
use PDOStatement;

class Users extends AbstractMethods
{
    private PDO $connection;

    /**
     * @param Credentials $credentials
     */
    public function __construct(
        Credentials $credentials
    ) {
        $this->connection = $this->createConnection($credentials);
    }

    /**
     * @param Credentials $credentials
     * @return PDO
     */
    protected function createConnection(Credentials $credentials): PDO
    {
        try {
            $conn = new PDO(
                "mysql:host=$credentials->host;dbname=$credentials->dbname",
                $credentials->username,
                $credentials->password
            );
            $conn->setAttribute($conn::ATTR_ERRMODE, $conn::ERRMODE_EXCEPTION);
            $conn->setAttribute($conn::MYSQL_ATTR_FOUND_ROWS, true);

            return $conn;
        } catch (\Throwable $error) {
            error_log("Error while connecting to db:" . $error->getMessage());
            die();
        }
    }

    /**
     * @param array $select
     * @param array|null $filter
     * @return array
     */
    public function select(array $select, ?array $filter = null): array
    {
        $selectParams = implode(", ", $select);
        $query = "SELECT $selectParams FROM users";

        if (!empty($filter)) {
            $filterParamsString = $this->parseFilters($filter);
            $query .= " WHERE " . $filterParamsString;
        }
        $users = $this->connection->query($query);

        return $users->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $values
     * @return bool|PDOStatement
     */
    public function create(array $values): bool|PDOStatement
    {
        try {
            if (count($values) != 4) {
                throw new \InvalidArgumentException(
                    "Error while creating user: The number of values does not match the number of fields"
                );
            } else {
                $sql = "INSERT INTO users (email, name, age, password) VALUES (?, ?, ?, ?)";

                $query = $this->connection->prepare($sql);
                $query->execute(array_map("trim", $values));

                return $query;
            }
        } catch (\PDOException $exception) {
            error_log("Error while creating user: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * @param array $properties
     * @param array $filter
     * @param array $values
     * @return bool|PDOStatement
     */
    public function update(array $properties, array $filter, array $values): bool|PDOStatement
    {
        $requiredProperties = ["email", "name", "age"];
        $query = "UPDATE users SET ";


        /**
         * Тут не подойдет array_diff, т.к на изменение подается только одно поле, и разница между массивами будет всегда
         */
        foreach ($properties as $property) {
            if (!in_array($property, $requiredProperties)) {
                throw new \InvalidArgumentException(
                    "Error while updating user: invalid column name or count of properties and values does not match"
                );
            }
        }

        if (count($properties) === 1) {
            $implodedProps = array_shift($properties);

            $implodedProps .= " = ? ";
            $query .= $implodedProps; // Забыли при дебаге добавить эту строку, без нее ничего не работало, была строка типа
                                      // UPDATE users SET  WHERE id = ?;
        } else {
            $implodedProps = implode(" = ?, ", $properties);

            $query .= rtrim($implodedProps, ",");
        }

        if (empty($filter)) {
            throw new \InvalidArgumentException("Error while updating user: filter cannot be empty");
        }

        $filterParamsString = $this->parseFilters($filter);
        $query .= " WHERE " . $filterParamsString;

        $allValues = array_merge($values, array_values($filter));

        $q = $this->connection->prepare($query);
        $q->execute($allValues);

        return $q;
    }

    /**
     * @param array $filter
     * @return bool|PDOStatement
     */
    public function delete(array $filter): bool|PDOStatement
    {
        try {
            $query = "DELETE FROM users";

            if (empty($filter)) {
                throw new \InvalidArgumentException("Error while deleting user: filter cannot be empty");
            }

            $filterParamsString = $this->parseFilters($filter);
            $query .= " WHERE " . $filterParamsString;

            $q = $this->connection->prepare($query);
            $q->execute(array_values($filter));

            return $q;
        } catch (\PDOException $exception) {
            error_log("Error while deleting user: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * @param string $value
     * @return array|bool
     */
    public function searchUserByValue(string $value): array|bool
    {
        try {
            $query = "SELECT email, name, age FROM users WHERE email LIKE :value OR name LIKE :value OR age LIKE :value";

            $q = $this->connection->prepare($query);
            $q->execute(["value" => "%$value%"]);

            return $q->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $exception) {
            error_log("Error while searching user: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * @param array $filter
     * @return string
     */
    protected function parseFilters(array $filter): string
    {
        $filterParams = [];

        foreach ($filter as $key => $value) {
            if (is_array($value)) {
                $values = implode(',', array_map(function ($item) {
                    return "'" . trim($item) . "'";
                }, $value));
                $filterParams[] = trim($key) . " IN (" . $values . ")";
            } else {
                $filterParams[] = trim($key) . " = ?";
            }
        }

        $filterParamsString = implode(" AND ", $filterParams);

        return trim($filterParamsString);
    }
}
