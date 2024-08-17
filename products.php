<?php
include 'db_connect.php';

$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f3e9;
            color: #333;
        }
        h2 {
            color: #4b2e2e; 
        }
        .btn-success {
            background-color: #d4a373;
            border-color: #d4a373;
            font-weight: 600;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        .btn-success:hover {
            background-color: #c98d58;
            border-color: #c98d58;
            transform: translateY(-2px);
        }
        .table thead {
            background-color: #d2b48c; 
            color: #4b2e2e;
        }
        .table tbody tr {
            background-color: #fff8e1; 
        }
        .table tbody tr:nth-child(even) {
            background-color: #f5f5dc;
        }
        .btn-warning {
            background-color: #d2b48c; 
            border-color: #d2b48c;
        }
        .btn-warning:hover {
            background-color: #b8860b;
            border-color: #b8860b;
        }
        .btn-primary {
            background-color: #d4a373;
            border-color: #d4a373;
            font-weight: 600;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #c98d58;
            border-color: #c98d58;
            transform: translateY(-2px);
        }
        .btn-danger {
            background-color: #800000; 
            border-color: #800000;
        }
        .btn-danger:hover {
            background-color: #4b0000; 
            border-color: #4b0000;
        }
        .navbar {
            background-color: #d4a373;
        }
        .navbar-nav .nav-link {
            color: #fff;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #f1ece4;
        }
        .dropdown-menu {
            background-color: #d4a373;
            border: none;
        }
        .dropdown-item {
            color: #fff;
        }
        .dropdown-item:hover {
            background-color: #c98d58;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include 'adminnavbar.php'; ?>
    <div class="container mt-5">
        <h2>Products</h2>
        
        
        <div class="mb-3">
            <a href="add_product.php" class="btn btn-success">Add Product</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category ID</th>
                    <th>Image</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';
                
                
                $sql = "SELECT * FROM products";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($products as $product):
                ?>
                    <tr>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['category_id']; ?></td>
                        <td><img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" width="50"></td>
                        <td><?php echo $product['is_available'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <a href="toggle_availability.php?id=<?php echo $product['product_id']; ?>" class="btn btn-warning btn-sm">Toggle Availability</a>
                            <a href="edit_product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
