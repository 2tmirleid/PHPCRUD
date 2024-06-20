<?php

namespace App\DB\MySQL\Models;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Methods\AbstractMethods;

class Users extends AbstractMethods
{
    private \PDO $connection;

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
     * @return \PDO
     */
    protected function createConnection(Credentials $credentials): \PDO
    {
        try {
            $conn = new \PDO("mysql:host=$credentials->host;dbname=$credentials->dbname", $credentials->username, $credentials->password);
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
                $query->execute($values);

                return true;
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

            if (empty($filter)) {
                error_log("Error while updating user: filter cannot be empty");
                return false;
            }

            $filterParamsString = $this->parseFilters($filter);
            $query .= " WHERE " . trim($filterParamsString);

            $allValues = array_merge($values, array_values($filter));

            $q = $this->connection->prepare($query);
            $q->execute($allValues);

            return true;
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

            if (empty($filter)) {
                error_log("Error while deleting user: filter cannot be empty");
                return false;
            }

            $filterParamsString = $this->parseFilters($filter);
            $query .= " WHERE " . trim($filterParamsString);

            $q = $this->connection->prepare($query);
            $q->execute(array_values($filter));

            return true;
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
