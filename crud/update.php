<?php
include "header.php";
include "./mysql/config.php";
include "./mysql/methods/update.php";
include "validateUpdateForm.php";
?>

<?php
    $userID = $_GET["id"];
?>

<body>
<div class="container">
    <form action="update.php" method="POST" class="update">
        <input type="hidden" name="id" value="<?php echo $userID; ?>">
        <span>Что Вы хотите изменить?</span>
        <label>
            <select name="field">
                <option value="email" name="email">Почта</option>
                <option value="name" name="name">Имя</option>
                <option value="age" name="age">Возраст</option>
            </select>
        </label>
        <span>Введите новое значение</span>
        <label>
            <input type="text" placeholder="Новое значение" name="value">
        </label>
        <label>
            <input type="submit" value="Изменить">
        </label>
    </form>
</div>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST["id"];
    $filed = $_POST["field"];
    $value = $_POST["value"];

    $errors = validateUpdateForm($filed, $value);

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            print "$error<br>";
        }
    } else {
        $user = updateUser($ID, $filed, $value);

        if ($user) {
            header("Location: index.php");
        } else {
            print "Что-то пошло не так...";
        }
    }
}
?>

<?php include "footer.php"; ?>
