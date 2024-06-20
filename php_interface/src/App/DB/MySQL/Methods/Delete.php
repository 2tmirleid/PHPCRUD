<?php

namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;

class Delete
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
     * @param string $id
     * @return bool
     */
    public static function deleteUser(string $id): bool
    {
        try {
            self::init();
            self::$conn->delete(["id" => $id]);

            return true;
        } catch (\PDOException $exception) {
            error_log("Error while deleting user: " . $exception->getMessage());
            return false;
        }
    }
}