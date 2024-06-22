<?php

namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;
use App\DB\MySQL\Singleton;

class Create
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
     * @param string $email
     * @param string $name
     * @param int $age
     * @return bool
     */
    public function createUser(string $email, string $name, int $age): bool
    {
        try {
            $createUser = $this->conn->create([$email, $name, $age]);
            $rowCount = $createUser->rowCount();

            if ($rowCount <= 0) {
                return false;
            }

            return true;
        } catch (\PDOException $exception) {
            error_log("Error while creating user: " . $exception->getMessage());
            return false;
        }
    }
}