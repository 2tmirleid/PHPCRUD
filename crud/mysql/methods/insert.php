<?php
include "../config.php";

function insertUser(array $user): bool {
    global $conn;

    try {
        $q = $conn->prepare("INSERT INTO users (email, name, age) VALUES (?, ?, ?)");
        $result = $q->execute([$user["email"], $user["name"], $user["age"]]);

        return true;
    } catch (PDOException $exception) {
        error_log("Error inserting user: " . $exception->getMessage());
        return false;
    }
}