<?php
include "../config.php";

function deleteUser(string $ID): bool {
    global $conn;

    try {
        $sql = "DELETE FROM users WHERE _id = ?";
        $q = $conn->prepare($sql);
        $result = $q->execute([$ID]);

        return true;
    } catch (PDOException $exception) {
        error_log("Error deleting user: " . $exception->getMessage());
        return false;
    }
}