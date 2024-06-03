<?php include "header.php";
include "./mysql/config.php";
include "./mysql/methods/select.php";
?>

<?php
    $users = selectAllUsers();
?>

<body>
<div class="container">
    <table>
        <thead>
        <tr>
            <th>Почта</th>
            <th>Имя</th>
            <th>Возраст</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $users->fetch()) { ?>
        <tr>
            <!-- email -->
            <td><?php print "$row[email]" ?></td>
            <!-- name -->
            <td><?php print "$row[name]" ?></td>
            <!-- age -->
            <td><?php print "$row[age]" ?></td>
            <!-- actions -->
            <td>
                <form action="update.php" method="GET" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $row["_id"]; ?>">
                    <button type="submit">Изменить</button>
                </form>
                <form action="delete.php" method="POST" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $row["_id"]; ?>">
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <form action="create.php" style="display: inline;">
        <button type="submit">Добавить</button>
    </form>
</div>
</body>

<?php include "footer.php"; ?>