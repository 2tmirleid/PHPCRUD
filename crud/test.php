<?php
//    require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/header.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/mysql/config.php";

/**
 * @var string $host
 * @var string $dbname
 * @var string $username
 * @var string $password
 */
?>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/php_interface/lib/vendor/autoload.php" ?>

<?php
    $testconn = new \App\DB\MySQL\Models\Users(
        host: $host,
        dbname: $dbname,
        username: $username,
        password: $password,
    );

//    $testarray = $testconn->select(select: ["_id", "name", "age"], filter: ["_id" => ['2', '7']]);
//    $testarray = $testconn->create(values: ["test", "123", "123"]);
//    $testarray = $testconn->update(properties: ["name", "age"], filter: ["_id" => '9'], values: ["test", "333"]);
//      $testarray = $testconn->delete(filter: ["_id" => '6']);

    echo '<pre>' . __FILE__ . ':' . __LINE__ . ':<br>' . var_export($testarray, true) . '</pre>'; //TODO: DELETE LOGGING


?>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/crud/footer.php"; ?>
