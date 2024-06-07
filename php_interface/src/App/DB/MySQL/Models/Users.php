<?php

namespace App\DB\MySQL\Models;

use App\DB\Methods\AbstractMethods;

class Users extends AbstractMethods
{
    private \PDO $connection;

    /**
     * @param string $host
     * @param string $dbname
     * @param string $username
     * @param string $password
     */
    public function __construct(
        protected string $host,
        protected string $dbname,
        protected string $username,
        protected string $password,
    ) {
        $this->connection = $this->createConnection();
    }

    /**
     * @return \PDO
     */
    protected function createConnection(): \PDO
    {
        try {
            $conn = new \PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute($conn::ATTR_ERRMODE, $conn::ERRMODE_EXCEPTION);

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
            $query .= " WHERE " . trim($filterParamsString);
        }
        $users = $this->connection->query($query);

        return $users->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $values
     * @return bool
     */
    public function create(array $values): bool
    {
        try {
            if (count($values) != 3) {
                error_log("Error while creating user: The number of values does not match the number of fields");
                return false;
            } else {
                $sql = "INSERT INTO users (email, name, age) VALUES (?, ?, ?)";
                $query = $this->connection->prepare($sql);

                return $query->execute($values);
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
     * @return bool
     */
    public function update(array $properties, array $filter, array $values): bool
    {
        try {
            $requiredProperties = ["email", "name", "age"];
            $query = "UPDATE users SET";

            foreach ($properties as $property) {
                if (!in_array($property, $requiredProperties)) {
                    error_log("Error while updating user: there is no column with name $property");
                    return false;
                }
            }

            if (count($properties) != count($values)) {
                error_log("Error while updating user: count of properties and values does not match");
                return false;
            }

            $setProperties = [];
            foreach ($properties as $property) {
                $setProperties[] = " $property = ?";
            }
            $query .= implode(",", $setProperties);

            if (!empty($filter)) {
                $filterParamsString = $this->parseFilters($filter);
                $query .= " WHERE " . trim($filterParamsString);
            } else {
                error_log("Error while updating user: filter cannot be empty");
                return false;
            }

            $allValues = array_merge($values, array_values($filter));

            $q = $this->connection->prepare($query);

            return $q->execute($allValues);
        } catch (\PDOException $exception) {
            error_log("Error while updating user: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * @param array $filter
     * @return bool
     */
    public function delete(array $filter): bool
    {
        try {
            $query = "DELETE FROM users";

            if (!empty($filter)) {
                $filterParamsString = $this->parseFilters($filter);
                $query .= " WHERE " . trim($filterParamsString);
            } else {
                error_log("Error while deleting user: filter cannot be empty");
                return false;
            }

            $q = $this->connection->prepare($query);

            return $q->execute(array_values($filter));
        } catch (\PDOException $exception) {
            error_log("Error while deleting user: " . $exception->getMessage());
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

        return implode(" AND ", $filterParams);
    }
}