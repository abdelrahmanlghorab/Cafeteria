<?php
include 'db_connect.php';

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_GET['id'];
    $product_name = trim($_POST['product_name']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;
     
    $errors = [];
    $old_data = [];
    
    if (empty($product_name)) {
        $errors['product_name'] = 'Product name is required';
    }else{
        $old_data = $product_name;
    }

    
    if (empty($price)) {
        $errors['price'] = 'Price is required';
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors['price'] = 'Price must be a positive number';
    }else{
        $old_data = $price;
    }
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
    
    if (empty($category_id)) {
        $errors['category_id'] = 'Category is required';
    }else{
        $old_data = $category_id;
    }

        if (!empty($errors)) {
    
        header("Location: edit_product.php?id=$product_id&" . urlencode($product_id) . '&errors=' . urlencode(json_encode($errors)) . '&old_data=' . urlencode(json_encode([
            'product_name' => $product_name,
            'price' => $price,
            'category_id' => $category_id,
            'is_available' => $is_available
        ])));
        exit;
    }

    try {

        if(!empty($image)){
            $sql = "UPDATE products SET product_name = :product_name, price = :price, category_id = :category_id, image = :image , is_available = :is_available WHERE product_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'product_name' => $product_name,
                'price' => $price,
                'category_id' => $category_id,
                'is_available' => $is_available,
                'image' => $image,
                'id' => $product_id
            ]);
        }else{
            $sql = "UPDATE products SET product_name = :product_name, price = :price, category_id = :category_id, is_available = :is_available WHERE product_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'product_name' => $product_name,
                'price' => $price,
                'category_id' => $category_id,
                'is_available' => $is_available,
                'id' => $product_id
            ]);
        }
        // $sql = "UPDATE products SET product_name = :product_name, price = :price, category_id = :category_id, image = :image , is_available = :is_available WHERE product_id = :id";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute([
        //     'product_name' => $product_name,
        //     'price' => $price,
        //     'category_id' => $category_id,
        //     'is_available' => $is_available,
        //     'id' => $product_id
        // ]);

        
        header("Location: products.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
