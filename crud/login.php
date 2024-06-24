<?php

use App\DB\MySQL\Methods\Select;
use App\Utils\Validation;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<main>
    <div class="container">
        <h2>Login Form</h2>
        <form class="user-form" action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Sign in</button>
            <a href="register.php">Doesn't has an account?</a>
        </form>
    </div>
</main>

<?php
$validator = new Validation();
$select = Select::getInstance();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = $validator->VerifyLogin(email: $email, password: $password);

    if (!empty($errors)) {
        foreach ($errors as $error) {
            print $error;
        }
    } else {
        $user = $select->selectUserByEmail(email: $email);

        $user_session_id = $user[0]["id"];

        session_start();
        $_SESSION["user_id"] = $user_session_id;

        header("Location: index.php");
        exit();
    }
}
?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
