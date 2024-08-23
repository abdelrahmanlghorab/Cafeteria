<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_GET['user_id'];
    $comment = $_POST['comment'];
    $room = $_POST['room'];
    $total_price = 0;
    $products = $_POST['products'];
    if(empty($products)){
        header("Location: add_user_order.php?message=No Products Selected");
        exit();
    }

    try {
        
        $pdo->beginTransaction();

        
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, date, comment, total_price, status) VALUES (?, NOW(), ?, ?, 'pending')");
        $stmt->execute([$user_id, $comment, $total_price]);
        $order_id = $pdo->lastInsertId();

        
        foreach ($products as $product) {
            $product_id = $product['id'];
            $quantity = $product['quantity'];
            $price = $product['price'];

            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$order_id, $product_id, $quantity, $price]);

            $total_price += $quantity * $price;
        }

        
        $stmt = $pdo->prepare("UPDATE orders SET total_price = ? WHERE order_id = ?");
        $stmt->execute([$total_price, $order_id]);

    
        $pdo->commit();

        header("Location: myorders.php");
    } catch (Exception $e) {
        
        $pdo->rollBack();
        echo "Failed to place order: " . $e->getMessage();
    }
}
