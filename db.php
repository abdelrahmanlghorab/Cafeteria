<?php
$dsn = 'mysql:host=localhost;dbname=cafeteria;charset=utf8mb4';
$username = 'root';
$password = '123456';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
?>
