<?php
$dsn = 'mysql:host=localhost;dbname=cafeteria';
$username = 'root';
$password = '123456';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['order_id'])) {
        $orderId = $_GET['order_id'];
        
        $stmt = $pdo->prepare("UPDATE orders SET status = 'completed' WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);

        header('Location: check.php');
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
