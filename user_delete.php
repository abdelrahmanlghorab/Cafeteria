<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    
    $sql = "SELECT image FROM users WHERE user_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $sql = "DELETE FROM users WHERE user_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $user_id]);

    
    if ($user && file_exists("path/to/your/images/folder/" . $user['image'])) {
        unlink("path/to/your/images/folder/" . $user['image']);
    }

    header("Location: users.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
