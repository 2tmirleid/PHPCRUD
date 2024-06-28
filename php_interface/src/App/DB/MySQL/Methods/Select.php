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

    /**
     * @param string $value
     * @return array
     */
    public function searchUserByValue(string $value): array
    {
        return $this->conn->searchUserByValue(value: $value);
    }

    /**
     * @param string $email
     * @return array
     */
    public function selectUserEmailAndHash(string $email): array
    {
        $userEmail = $this->conn->select(select: ["id", "email"], filter: ["email" => [$email]]);
        $userHash = $this->conn->select(select: ["password"], filter: ["email" => [$email]]);

        $implodedEmail = array_shift($userEmail);
        $implodedHash = array_shift($userHash);

        return [
            "email" => $implodedEmail["email"],
            "hash" => $implodedHash["password"]
        ];
    }
}
