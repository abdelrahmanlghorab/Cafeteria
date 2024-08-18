<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db.php';

    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE user_name = :user_name");
    $stmt->bindParam(':user_name', $user_name);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE user_name = :user_name");
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_name', $user_name);

        if ($stmt->execute()) {
            $message = "Password reset successfully for user: $user_name";
            header("Location: login.php?message=" . urlencode($message));
        } else {
            $message = "Error resetting password for user: $user_name";
            header("Location: forget.php?message=" . urlencode($message));
        }
    }else {
        $message = "User not found: $user_name";
        header("Location: forget.php?message=" . urlencode($message));
    }
    
}
?>
