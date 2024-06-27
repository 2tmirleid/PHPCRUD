<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validator = new Validation();

    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = $validator->verifyLogin(email: $email, password: $password);

    if (!empty($errors)) {
        foreach ($errors as $error) {
            print $error;
        }
    } else {
        Authentication::authenticate($email);

        header("Location: index.php");
    }
}
?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
