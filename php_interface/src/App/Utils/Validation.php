<?php

namespace App\Utils;

use App\DB\MySQL\Methods\Select;

class Validation
{
    /**
     * @param string $age
     * @param string|null $email
     * @return array
     */
    public static function validateForm(string $age, ?string $email = null): array
    {
        $errors = [];

        $isEmailExists = Select::selectUserByEmail(email: $email);

        if (!empty($isEmailExists)) {
            $errors[] = "User with same email already exists<br>";
        }

        if ((int)$age < 18) {
            $errors[] = "Sorry, you are too little for our website<br>";
        }

        return $errors;
    }
}