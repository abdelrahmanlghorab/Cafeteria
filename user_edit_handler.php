<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';


    try {
        $user_id = $_POST['user_id'];
        $user_name = trim($_POST['user_name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $room = trim($_POST['room']);
        $Ext = trim($_POST['Ext']);
        $role_id = $_POST['role_id'];
        $current_image = $_POST['current_image'];
        $image = $current_image;

        $errors = [];
        

        // Validation
        if (empty($user_name)) {
            $errors['user_name'] = 'User name is required.';
        } 

        if (empty($email)) {
            $errors['email'] = 'Email is required.';
        }

        if (strlen($password) > 0 && strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters long.';
        } elseif (strlen($password) > 0) {
            $passwordHash = $password;
        }

        if (empty($room)) {
            $errors['room'] = 'Room is required.';
        } else {
            $old_data['room'] = $room;
        }

        if (empty($Ext)) {
            $errors['Ext'] = 'Ext is required.';
        } 

        if (empty($role_id)) {
            $errors['role_id'] = 'Role is required.';
        } 
        if (!empty($errors)) {
            $errors = json_encode($errors);
            header("Location: user_edit.php?id=$user_id&errors=$errors");
            exit();
        }

        // Handle image upload
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

            if (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                throw new Exception("Sorry, only JPG, JPEG, & PNG files are allowed.");
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Remove old image if exists
                if (!empty($current_image) && file_exists($target_dir . $current_image)) {
                    unlink($target_dir . $current_image);
                }
                $image = basename($_FILES["image"]["name"]);
            } else {
                throw new Exception("Sorry, there was an error uploading your file.");
            }
        }

        // Prepare SQL query
        $sql = "UPDATE users SET user_name = :user_name, email = :email, room = :room, Ext = :Ext, image = :image, role_id = :role_id";
        
        // Add password field if it's set
        if (!empty($passwordHash)) {
            $sql .= ", password = :password";
        }
        
        $sql .= " WHERE user_id = :user_id";
        
        $stmt = $conn->prepare($sql);

        $params = [
            'user_name' => $user_name,
            'email' => $email,
            'room' => $room,
            'Ext' => $Ext,
            'image' => $image,
            'role_id' => $role_id,
            'user_id' => $user_id
        ];

        if (!empty($passwordHash)) {
            $params['password'] = $passwordHash;
        }

        $stmt->execute($params);

        header("Location: users.php");
        exit();

    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }

?>
