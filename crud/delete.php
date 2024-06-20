<?php

use App\DB\MySQL\Methods\Delete;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST["id"];

    $deleteUser = Delete::deleteUser($userID);

    if ($deleteUser) {
        header("Location: index.php");
    } {
        print("Smth went wrong...");
    }
}

?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
