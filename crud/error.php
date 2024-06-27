<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
?>

<?php
/**
 * @var string $errorMessage
 */
?>
<main>
    <div class='container'>
        <h2><?= $errorMessage ?: "Smth went wrong..." ?></h2>
    </div>
</main>

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php";
?>