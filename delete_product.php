<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    
    $sql = "SELECT image FROM products WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $image_path = './images/' . $product['image'];

        
        if (file_exists($image_path)) {
            unlink($image_path); 
        }

        
        $sql = "DELETE FROM products WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $product_id]);

       
        header("Location: products.php");
        exit();
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>
