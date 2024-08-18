<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db.php';
$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); 
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['role'] = $user['role_id'];
            if ($_SESSION ['role'] == 1 ){
               header("Location: add_user_order.php");  
            }
             elseif ($_SESSION ['role'] == 2) {
                header("Location: admin_order_add.php");  
             }
            exit();
        } else {
            
            $errors['login'] = "Invalid email or password.";
    header('Location: login.php?errors=' . json_encode($errors));
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
