<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $user_name = $_POST['user_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $room = $_POST['room'];
        $Ext = $_POST['Ext'];
        $role_id = $_POST['role_id'];

        
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

        $sql = "INSERT INTO users (user_name, email, password, room, Ext, image, role_id) VALUES (:user_name, :email, :password, :room, :Ext, :image, :role_id)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'user_name' => $user_name,
            'email' => $email,
            'password' => $password,
            'room' => $room,
            'Ext' => $Ext,
            'image' => $image,
            'role_id' => $role_id
        ]);

        header("Location: users.php");
        exit();

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
