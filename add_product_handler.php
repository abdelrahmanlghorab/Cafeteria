<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $product_name = trim($_POST['product_name']);
        $price = trim($_POST['price']);
        $category_id = $_POST['category_id'];
        $errors = [];
        $old_data = [
            'product_name' => $product_name,
            'price' => $price,
            'category_id' => $category_id
        ];

        // Validate inputs
        if (empty($product_name)) {
            $errors['product_name'] = 'Product name is required.';
        }
        
        if (empty($price)) {
            $errors['price'] = 'Price is required.';
        } elseif (!is_numeric($price) || $price <= 0) {
            $errors['price'] = 'Price must be a positive number.';
        }
        
        if (empty($category_id)) {
            $errors['category_id'] = 'Category is required.';
        }
        
        // Handle file upload
        $image = null;
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "./images/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                $errors['image'] = 'File is not an image.';
            }

            if (file_exists($target_file)) {
                $errors['image'] = 'Sorry, file already exists.';
            }

            if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                $errors['image'] = 'Sorry, only JPG, JPEG, & PNG files are allowed.';
            }

            if (empty($errors)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = basename($_FILES["image"]["name"]);
                } else {
                    $errors['image'] = 'Sorry, there was an error uploading your file.';
                }
            }
        }

        if (!empty($errors)) {
            // Redirect back with errors and old data
            $query = http_build_query([
                'errors' => json_encode($errors),
                'old_data' => json_encode($old_data)
            ]);
            header("Location: add_product.php?$query");
            exit;
        }

        // Insert product into the database
        $sql = "INSERT INTO products (product_name, price, category_id, image) VALUES (:product_name, :price, :category_id, :image)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'product_name' => $product_name,
            'price' => $price,
            'category_id' => $category_id,
            'image' => $image
        ]);

        header("Location: products.php");
        exit();

    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}
?>
