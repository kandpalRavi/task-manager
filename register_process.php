<?php
$pdo = require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        // Check if the username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            // Redirect back to the registration page with an error message
            header('Location: register.php?error=User  or email already exists');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        header('Location: login.php?registered=1');
    } catch (PDOException $e) {
        // Log the error message for debugging
        error_log($e->getMessage());
        header('Location: register.php?error=An error occurred during registration');
    }
}
?>