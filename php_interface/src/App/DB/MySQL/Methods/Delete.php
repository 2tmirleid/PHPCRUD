<?php

namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;
use App\DB\MySQL\Singleton;

class Delete
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
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        try {
            $deleteUser = $this->conn->delete(["id" => $id]);
            $rowCount = $deleteUser->rowCount();

            if ($rowCount <= 0) {
                return false;
            }

            return true;
        } catch (\PDOException $exception) {
            error_log("Error while deleting user: " . $exception->getMessage());
            return false;
        }
    }
}