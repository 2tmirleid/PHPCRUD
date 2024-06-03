<?php
include "./mysql/config.php";
include "./mysql/methods/delete.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = deleteUser($_POST["id"]);

    if ($user) {
        header("Location: index.php");
    } else {
        print "Что-то пошло не так";
    }
}