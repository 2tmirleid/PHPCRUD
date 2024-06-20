<?php

use App\DB\MySQL\Methods\Update;
use App\Utils\Validation;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<?php
$userID = $_GET["id"];
?>

<main>
    <div class="container">
        <h2>Изменить пользователя</h2>
        <form action="update.php" method="POST" class="user-form">
            <input type="hidden" name="id" value="<?= $userID ?>">

            <div class="form-group">
                <label for="field">Поле для изменения</label>
                <select name="field" id="field">
                    <option value="email">Email</option>
                    <option value="name">Name</option>
                    <option value="age">Age</option>
                </select>
            </div>

            <div class="form-group">
                <label for="new_value">Новое значение</label>
                <input type="text" id="new_value" name="new_value" required>
            </div>

            <button type="submit" class="submit-btn">Изменить</button>
        </form>
    </div>
</main>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = $_POST["field"];
    $value = $_POST["new_value"];
    $userID = $_POST["id"];

    if ($field == "age") {
        $age = $value;

        $errors = Validation::validateForm(age: $age);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                print "$error";
            }
        }
    } else {
        $updateUser = Update::updateUser(field: $field, filter: $userID, value: $value);

        if ($updateUser) {
            header("Location: index.php");
        } else {
            print "Smth went wrong...";
        }
    }
}
?>


<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>
