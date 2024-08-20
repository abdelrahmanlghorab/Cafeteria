<?php

$servername = "localhost";
$username = "abdo";
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

$user_id = $_SESSION['user_id']; 
 if(empty($user_id)){
    header("location:login.php");
}

$query = "SELECT user_name, image FROM users WHERE user_id = :user_id";
$stmt = $con->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$username = $user['user_name'] ?? 'Guest';
$image = $user['image'] ?? 'default.jpg';
$role_id=$user['role_id'];
if($role_id==2){
    $role_name="Admin";
}
elseif($role_id==1){
    $role_name="User";
}
else{
    $role_name="Guest";
}
if($role_name=="Admin"){
    header("location:admin_order_add.php");
}
else{
    header("location:add_user_order.php");
}
?>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="admin_order_add.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="products.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users.php">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders_filter.php">Order Filter</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="check.php">Checks</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/<?php echo htmlspecialchars($image); ?>" alt="User Image" class="rounded-circle me-2" width="40" height="40">
                    <span><?php echo htmlspecialchars($username); ?></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                   <?php 
                  if($user['user_name']){ echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>'; }
                  else{ echo '<li><a class="dropdown-item" href="login.php">Login</a></li>'; }
                  ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></script>

