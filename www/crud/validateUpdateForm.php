<?php

function validateUpdateForm(string $filed ,string $value): array {
    $errors = [];

    switch ($filed) {
        case "email":
            if (strlen($value) == 0) {
                $errors[] = "Поле \"Почта\" должно включать в себя больше 0 символов";
            }
            break;
        case "name":
            if (strlen($value) < 2) {
                $errors[] = "Поле \"Имя\" должно включать в себя больше 2х символов";
            }
            break;
        case "age":
            if ((int)$value < 18) {
                $errors[] = "Возраст пользователя должен быть больше 18и лет";
            }
            break;
        default:
            $errors[] = "Некорректное поле для обновления";
            break;
    }

    return $errors;
}
