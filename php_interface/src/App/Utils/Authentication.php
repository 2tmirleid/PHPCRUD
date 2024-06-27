<?php

namespace App\Utils;

class Authentication
{
    public static function authenticate(int $id, string $email): void
    {
        session_start();

        $_SESSION["user_id"] = $id;
        $_SESSION["user_email"] = $email;
    }
}