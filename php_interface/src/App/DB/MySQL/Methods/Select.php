<?php
namespace App\DB\MySQL\Methods;

use App\DB\MySQL\Credentials;
use App\DB\MySQL\Models\Users;
use App\DB\MySQL\Singleton;

class Select
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
     * @return array
     */
    public function selectAllUsers(): array
    {
        return $this->conn->select(select: ["id", "email", "name", "age"]);

    }

    /**
     * @param string $email
     * @return array
     */
    public function selectUserByEmail(string $email): array
    {
        return $this->conn->select(select: ["id", "email"], filter: ["email" => [$email]]);
    }

    public function searchUserByValue(string $value): array // Это не смотри, я пока не доделал
    {
        return $this->conn->searchUserByValue(value: $value); // TODO validate values
    }

    public function selectUserHashByEmail(string $email): array
    {
        return $this->conn->select(select: ["password"], filter: ["email" => [$email]]);
    }

    public function selectEmailByID(int $userID): array
    {
        return $this->conn->select(select: ["email"], filter: ["id" => [$userID]]);
    }
}
