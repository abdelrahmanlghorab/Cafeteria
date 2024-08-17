<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];

        
        $image = null;
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "./images/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

           
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                throw new Exception("File is not an image.");
            }

           
            if (file_exists($target_file)) {
                throw new Exception("Sorry, file already exists.");
            }

            
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                throw new Exception("Sorry, only JPG, JPEG, & PNG files are allowed.");
            }

            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["image"]["name"]);
            } else {
                throw new Exception("Sorry, there was an error uploading your file.");
            }
        }

        
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
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
