<?php

$servername = "localhost";
$username = "root";
$password = "123456";
$database = "cafeteria";

try {
    $con = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
 if(empty($user_id)){
    header("location:login.php");
}
$role= $_SESSION['role'];
if($role!=1){
    header("location:add_user_order.php");
}

$query = "SELECT user_name, image FROM users WHERE user_id = :user_id";
$stmt = $con->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$username = $user['user_name'] ?? 'Guest';
$image = $user['image'] ?? 'default.jpg';
?>

<nav class="navbar navbar-expand-lg" style="background-color: #8b6139 !important;">
    <div class="container">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
            <a class="navbar-brand" href="add_user_order.php" style="color: #fff; font-weight: bold;">
                <img src="./images/logo.png" alt="cafeteria" width="45">
                Cafeteria
            </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="myorders.php">My Orders</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/<?php echo htmlspecialchars($image); ?>" alt="User Image" class="rounded-circle me-2" width="40" height="40">
                    <span><?php echo htmlspecialchars($username); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
