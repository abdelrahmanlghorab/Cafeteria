<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      
        $user_id = $_POST['user_id'];
        $comment = $_POST['comment'];
        $total_price = $_POST['total_price'];
        $order_status = 'pending';
        $products = $_POST['products'];
        if(empty($products)){
            header("Location: admin_order_add.php?message=No Products Selected");
            exit();
        }
        $pdo->beginTransaction();

       
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, date, comment, total_price, status) 
            VALUES (:user_id, NOW(), :comment, :total_price, :status)
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':comment' => $comment,
            ':total_price' => $total_price,
            ':status' => $order_status,
        ]);

       
        $order_id = $pdo->lastInsertId();

       
        foreach ($_POST['products'] as $product_id => $product_details) {
            $quantity = $product_details['quantity'];
            $price = $product_details['price'];

            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (:order_id, :product_id, :quantity, :price)
            ");
            $stmt->execute([
                ':order_id' => $order_id,
                ':product_id' => $product_id,
                ':quantity' => $quantity,
                ':price' => $price,
            ]);
        }

        
        $pdo->commit();

        
        header("Location: check.php");
        exit();
    } catch (Exception $e) {
        
        $pdo->rollBack();
        echo "Failed to place order: " . $e->getMessage();
    }
}
?>

