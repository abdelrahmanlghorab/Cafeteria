<?php
include 'db_connect.php';

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_GET['id'];
    $product_name = trim($_POST['product_name']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $is_available = isset($_POST['is_available']) ? 1 : 0; 
    $errors = [];
    
    
    if (empty($product_name)) {
        $errors['product_name'] = 'Product name is required';
    }

    
    if (empty($price)) {
        $errors['price'] = 'Price is required';
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors['price'] = 'Price must be a positive number';
    }

    
    if (empty($category_id)) {
        $errors['category_id'] = 'Category is required';
    }

        if (!empty($errors)) {
    
        header('Location: edit_product.php?id=' . urlencode($product_id) . '&errors=' . urlencode(json_encode($errors)) . '&old_data=' . urlencode(json_encode([
            'product_name' => $product_name,
            'price' => $price,
            'category_id' => $category_id,
            'is_available' => $is_available
        ])));
        exit;
    }

    try {
        
        $sql = "UPDATE products SET product_name = :product_name, price = :price, category_id = :category_id, is_available = :is_available WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'product_name' => $product_name,
            'price' => $price,
            'category_id' => $category_id,
            'is_available' => $is_available,
            'id' => $product_id
        ]);

        
        header("Location: products.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
