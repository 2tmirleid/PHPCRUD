<?php

use App\DB\MySQL\Methods\Create;
use App\Utils\Validation;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<main>
    <div class="container">
        <h2>Добавить пользователя</h2>
        <form action="create.php" method="POST" class="user-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>
            <button type="submit" class="submit-btn">Создать</button>
        </form>
    </div>
</main>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $age = $_POST["age"];

    $errors = Validation::validateForm(age: $age, email: $email);

    if (!empty($errors)) {
        foreach ($errors as $error) {
            print $error;
        }
    } else {
        $user = Create::createUser(email: $email, name: $name, age: $age);

        if ($user) {
            header("Location: index.php");
        } else {
            print "Smth went wrong...";
        }
    }
}
?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
