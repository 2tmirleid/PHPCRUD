<?php

namespace App\Utils;

use App\DB\MySQL\Methods\Select;

class Authentication
{
    public static function authenticate(string $email): void
    {
        $user = Select::getInstance()->selectUserByEmail(email: $email);

        $userSessionID = intval($user[0]["id"]);
        $userSessionEmail = $user[0]["email"];

        if (empty($userSessionID) || empty($userSessionEmail)) {
            include $_SERVER["DOCUMENT_ROOT"] . "/crud/error.php";
            die();
        }

        session_start();

        $_SESSION["user_id"] = $userSessionID;
        $_SESSION["user_email"] = $userSessionEmail;
    }
}