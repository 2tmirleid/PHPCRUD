<?php
namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;

class Select
{
    private static $conn;

    private static function init()
    {
        if (self::$conn === null) {
            self::$conn = new Users(
                new Credentials()
            );
        }
    }

    /**
     * @return array
     */
    public static function selectAllUsers(): array
    {
        self::init();
        return self::$conn->select(select: ["id", "email", "name", "age"]);
    }

    /**
     * @param string $email
     * @return array
     */
    public static function selectUserByEmail(string $email): array
    {
        self::init();
        return self::$conn->select(select: ["email"], filter: ["email" => [$email]]);
    }
}
