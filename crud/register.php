<?php

use App\DB\MySQL\Methods\Create;
use App\Utils\Validation;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<main>
    <div class="container">
        <h2>Registration Form</h2>
        <form class="user-form" action="register.php" method="POST">
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
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>
</main>

<?php
$validator = new Validation();
$create = Create::getInstance();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $age = intval($_POST["age"]);
    $password = $_POST["password"];

    $errors = $validator->validateForm(password: $password, age: $age, email: $email);

    if (!empty($errors)) {
        foreach ($errors as $error) {
            print $error;
        }
    } else {
        $registerUser = $create->register(email: $email, name: $name, age: $age, password: $password);

        if ($registerUser) {
            print "Success";
        } else {
            $error = "
                <main>
                <div class='container'>
                <h2>Smth went wrong...</h2>
                </div>
                </main>
            ";

            die($error);
        }
    }
}
?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
