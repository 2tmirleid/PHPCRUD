<?php

namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;

class Create
{
    private static $conn;

    private static function init(): void
    {
        if (self::$conn === null) {
            self::$conn = new Users(
                new Credentials()
            );
        }
    }

    /**
     * @param string $email
     * @param string $name
     * @param string $age
     * @return bool
     */
    public static function createUser(string $email, string $name, string $age): bool
    {
        try {
            self::init();
            self::$conn->create([$email, $name, $age]);

            return true;
        } catch (\PDOException $exception) {
            error_log("Error while creating user: " . $exception->getMessage());
            return false;
        }
    }
}