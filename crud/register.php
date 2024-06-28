<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";

use App\DB\MySQL\Methods\Create;
use App\Utils\Authentication;
use App\Utils\Validation;

?>

<?php
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
}
?>

<main>
    <div class="container">
        <h2>Registration Form</h2>
        <form class="user-form" action="register.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $_POST["email"] ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?= $_POST["name"] ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?= $_POST["age"] ?>" required>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validator = new Validation();

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
        $registerUser = Create::getInstance()->register(email: $email, name: $name, age: $age, password: $password);

        if ($registerUser) {
            Authentication::authenticate($email);

            header("Location: index.php");
        } else {
            include $_SERVER["DOCUMENT_ROOT"] . "/crud/error.php";
            die();
        }
    }
}
?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
