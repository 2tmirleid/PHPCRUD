<?php

namespace App\Utils;

use App\DB\MySQL\Methods\Select;

class Validation
{
    private $select;

    public function __construct()
    {
        $this->select = Select::getInstance();
    }

    /**
     * @param int|null $age
     * @param string|null $email
     * @return array
     */
    public function validateForm(?int $age = null, ?string $email = null): array
    {
        $errors = [];

        $correctEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

        if (!$correctEmail) {
            $errors[] = "Sorry, your email is incorrect";
        } else {
            $isEmailExists = $this->select->selectUserByEmail(email: $correctEmail);
        }

        if (!empty($isEmailExists)) {
            $errors[] = "User with same email already exists<br>";
        }

        if (isset($age)) {
            if ($age < 18) {
                $errors[] = "Sorry, you are too little for our website<br>";
            }
        }

        return $errors;
    }
}