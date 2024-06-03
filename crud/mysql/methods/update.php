<?php
include "../config.php";

function updateUser(string $ID, string $property, string $value): bool {
    global $conn;

    try {
        $sql = "UPDATE users SET $property = ? WHERE _id = ?";
        $q = $conn->prepare($sql);
        $result = $q->execute([$value, $ID]);

        return true;
    } catch (PDOException $exception) {
        error_log("Error updating user: " .$exception->getMessage());
        return false;
    }
}