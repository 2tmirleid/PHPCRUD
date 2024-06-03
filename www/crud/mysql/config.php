<?php

$host = "bitrixdock_db";
$dbname = "bitrix";
$username = "bitrix";
$password = "123";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    error_log("Error while connecting to db:" . $exception->getMessage());
}
