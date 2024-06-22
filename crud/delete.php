<?php

use App\DB\MySQL\Methods\Delete;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete = Delete::getInstance();

    $userID = intval($_POST["id"]);

    $deleteUser = $delete->deleteUser($userID);

    if ($deleteUser) {
        header("Location: index.php");
    } {
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

?>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
