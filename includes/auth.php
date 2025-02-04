<?php
session_start();

function registerUser($username, $password, $email) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $email]);
}

function loginUser($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}
?>