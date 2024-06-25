<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";

use App\DB\MySQL\Methods\Delete;
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete = Delete::getInstance();

    $userID = intval($_POST["id"]);

    $deleteUser = $delete->deleteUser($userID);

    if ($deleteUser) {
        header("Location: index.php");
    } else {
        include $_SERVER["DOCUMENT_ROOT"] . "/crud/error.php";
        die();
    }
}

?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
