<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/php_interface/lib/vendor/autoload.php"
?>

<?php
session_start();

$email = null;

if (isset($_SESSION["user_email"])) {
    $email = $_SESSION["user_email"];
}
?>

    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/reset.css">

        <link rel="stylesheet" href="css/styles.css">

        <title>CRUD</title>
    </head>
    <body>
    <header>
        <div class="container">
            <h1><a href="index.php">C.R.U.D.</a></h1>
            <span><?= $email ?></span>
            <?php
                session_start();

                if (isset($_SESSION["user_id"])) { ?>
                    <form action="logout.php" method="POST">
                        <button>Log out</button>
                    </form>
            <?php } ?>
        </div>
    </header>

<?php
session_start();

$currentFile = basename($_SERVER['PHP_SELF']);
$excludedPages = ['register.php', 'login.php'];

if (!in_array($currentFile, $excludedPages) && !isset($_SESSION["user_id"])) {
    header("Location: login.php");
}
?>