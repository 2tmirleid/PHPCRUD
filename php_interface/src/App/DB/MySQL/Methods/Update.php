<?php

namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;
use App\DB\MySQL\Singleton;

class Update
{
    use Singleton;
    private $conn;

    private function __construct()
    {
        $this->conn = new Users(
            new Credentials()
        );
    }

    /**
     * @param string $field
     * @param string $filter
     * @param string $value
     * @return bool
     */
    public function updateUser(string $field, string $filter, string $value): bool
    {
        try {
            $updateUser = $this->conn->update(properties: [$field], filter: ["id" => $filter], values: [$value]);
            $rowCount = $updateUser?->rowCount();

            return boolval($rowCount);
        } catch (\Throwable $exception) {
            error_log("Error while updating user: " . $exception->getMessage());
        }

        return false;
    }
}