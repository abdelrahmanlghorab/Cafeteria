<?php
include 'db_connect.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Update order status to 'cancelled'
    $query = "UPDATE orders SET status = 'cancelled' WHERE order_id = :order_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();

    echo 'Order cancelled successfully.';
}
?>