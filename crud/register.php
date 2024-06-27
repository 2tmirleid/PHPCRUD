<?php

use App\DB\MySQL\Methods\Create;
use App\DB\MySQL\Methods\Select;
use App\Utils\Authentication;
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
            <button type="submit" class="submit-btn">Sign up</button>
            <a href="login.php">Already has account?</a>
        </form>
    </div>
</main>

<?php
$validator = new Validation();
$create = Create::getInstance();
$select = Select::getInstance();

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
            $user = $select->selectUserByEmail(email: $email);

            $userSessionID = intval($user[0]["id"]);
            $userSessionEmail = $user[0]["email"];

            Authentication::authenticate(id: $userSessionID, email: $userSessionEmail);

            header("Location: index.php");
            exit();
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
