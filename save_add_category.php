<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = trim($_POST['category_name']);
    $errors = [];

    
    if (empty($category_name)) {
        $errors['category_name'] = 'Category name is required';
    } else {
        
        $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE category_name = :category_name");
        $stmt->execute(['category_name' => $category_name]);
        if ($stmt->fetchColumn() > 0) {
            $errors['category_name'] = 'Category name already exists';
        }
    }

    if (!empty($errors)) {
        header('Location: add_category.php?errors=' . urlencode(json_encode($errors)) . '&old_data=' . urlencode(json_encode(['category_name' => $category_name])));
        exit;
    }

    try {
        $sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'category_name' => $category_name
        ]);

        
        header("Location: add_product.php");
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
