<?php

use App\DB\MySQL\Methods\Select;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<?php
$select = Select::getInstance();

$users = $select->selectAllUsers();
?>

<main>
    <div class="container">
        <h2>Users List</h2>

        <!-- Search Form -->
        <form action="search.php" method="GET" class="user-form">
            <div class="form-group">
                <label for="search">Search Users</label>
                <input type="text" id="search" name="search" placeholder="Enter email, name, or age" required>
            </div>
            <button type="submit" class="submit-btn">Search</button>
        </form>

        <table class="user-table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user) { ?>
                <tr>
                    <td><?= $user["email"] ?></td>
                    <td><?= $user["name"] ?></td>
                    <td><?= $user["age"] ?></td>
                    <td>
                        <form action="update.php" method="GET">
                            <input type="hidden" name="id" value="<?= $user["id"]; ?>">
                            <button class="action-btn edit">Изменить</button>
                        </form>
                        <form action="delete.php" method="POST">
                            <input type="hidden" name="id" value="<?= $user["id"]; ?>">
                            <button class="action-btn delete">Удалить</button>
                        </form>
                    </td>
                </tr>
                <?php
            } ?>
            </tbody>
        </table>
        <button class="add-btn">
            <a href="create.php">Добавить</a>
        </button>
    </div>
</main>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>