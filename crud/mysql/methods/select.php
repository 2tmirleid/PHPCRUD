<?php

include "../config.php";

function selectAllUsers() {
    global $conn;

    return $conn->query("SELECT _id, email, name, age FROM users");
}

function selectUserByEmail(string $email): bool {
    global $conn;

    $q = $conn->prepare("SELECT _id FROM users WHERE email = ?");
    $q->execute([$email]);

    return (bool)$q->fetch();
}