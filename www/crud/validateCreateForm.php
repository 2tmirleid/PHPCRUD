<?php
include "./mysql/config.php";


function validateCreateForm(array $user): array {
    $errors = [];

    $email = selectUserByEmail($user["email"]);
    $name = trim($user["name"]);
    $age = trim($user["age"]);

    if ($email) {
        $errors[] = "Пользователь с таким email уже существует";
    } elseif (strlen($user["email"]) == 0) {
        $errors[] = "Поле \"Почта\" должно включать в себя больше 0 символов";
    }

    if (strlen($name) < 2) {
        $errors[] = "Поле \"Имя\" должно включать в себя больше 2х символов";
    }

    if ((int)$age < 18) {
        $errors[] = "Возраст пользователя должен быть больше 18и лет";
    }

    return $errors;
}