<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    
    $sql = "SELECT is_available FROM products WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        
        $new_status = $product['is_available'] ? 0 : 1;

        
        $sql = "UPDATE products SET is_available = :new_status WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['new_status' => $new_status, 'id' => $product_id]);
    }

    
    header("Location: products.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
