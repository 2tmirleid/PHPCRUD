<?php

use App\DB\MySQL\Methods\Select;

require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<?php
$select = Select::getInstance();

$searchValue = $_GET["search"];
$searchResults = $select->searchUserByValue(value: $searchValue);
?>
<main>
    <div class="container">
        <h2>Search results</h2>
        <table class="user-table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Age</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($searchResults)) {
                foreach ($searchResults as $result) { ?>
                    <tr>
                        <td><?= $result["email"] ?></td>
                        <td><?= $result["name"] ?></td>
                        <td><?= $result["age"] ?></td>
                    </tr>
                    <?php
                }
            } else {
            ?>
            </tbody>
        </table>
        <?php
        ?>
        <h2>Users not found :(</h2>
        <?php
        }
        ?>
    </div>
</main>
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>
