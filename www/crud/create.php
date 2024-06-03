<?php include "header.php";
include "./mysql/config.php";
include "./mysql/methods/select.php";
include "./mysql/methods/insert.php";
include "validateCreateForm.php";
?>

<body>
<div class="container">
    <form action="create.php" method="POST" class="create">
        <label>
            <span>Почта</span>
            <input type="email" placeholder="test@test.test" name="email"/>
        </label>
        <label>
            <span>Имя</span>
            <input type="text" placeholder="Valeriy" name="name">
        </label>
        <label>
            <span>Возраст</span>
            <input type="text" placeholder="21" name="age">
        </label>
        <label>
            <input type="submit" value="Добавить">
        </label>
    </form>
</div>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateCreateForm($_POST);

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            print "$error<br>";
        }
    } else {
        $user = insertUser($_POST);

        if ($user) {
            header("Location: index.php");
        } else {
            print "Что-то пошло не так...";
        }
    }
}
?>

<?php include "footer.php" ?>
