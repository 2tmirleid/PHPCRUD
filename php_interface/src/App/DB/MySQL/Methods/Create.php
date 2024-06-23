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
     * @param string $password
     * @return bool
     */
    public function register(string $email, string $name, int $age, string $password): bool
    {
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $registerUser = $this->conn->create([$email, $name, $age, $hashPassword]);
            $rowCount = $registerUser->rowCount();

            if ($rowCount <= 0) {
                return false;
            }

            return true;
        } catch (\PDOException $exception) {
            error_log("Error while register user: " . $exception->getMessage());
            return false;
        }
    }
}