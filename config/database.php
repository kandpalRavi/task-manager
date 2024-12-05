<?php
$host = 'localhost';
$dbname = 'task_manager';
$username = 'root';
$password = ''; // Empty password for default XAMPP setup

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
