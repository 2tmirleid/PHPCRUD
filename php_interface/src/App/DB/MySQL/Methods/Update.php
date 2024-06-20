<?php

namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;

class Update
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
     * @param string $field
     * @param string $filter
     * @param string $value
     * @return bool
     */
    public static function updateUser(string $field, string $filter, string $value): bool
    {
        try {
            self::init();
            self::$conn->update(properties: [$field], filter: ["id" => $filter], values: [$value]);

            return true;
        } catch (\PDOException $exception) {
            error_log("Error while updating user: " . $exception->getMessage());
            return false;
        }
    }
}