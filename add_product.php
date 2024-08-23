<?php
include 'db_connect.php';

try {
    $stmt = $conn->prepare("SELECT category_id, category_name FROM categories");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
}

// Get errors and old data from query parameters
$errors = isset($_GET['errors']) ? json_decode($_GET['errors'], true) : [];
$old_data = isset($_GET['old_data']) ? json_decode($_GET['old_data'], true) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >
    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #4b2e2e;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .btn-primary {
            background-color: #8b4513;
            border-color: #8b4513;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #5a2d0c;
            border-color: #5a2d0c;
        }
        .btn-secondary {
            background-color: #d2b48c;
            border-color: #d2b48c;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #a89b73;
            border-color: #a89b73;
        }
        .form-control {
            border: 1px solid #4b2e2e;
            background-color: #f5f5dc;
            color: #4b2e2e;
            border-radius: 10px;
            padding: 15px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #8b4513;
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }
        .form-group label {
            color: #4b2e2e;
            font-weight: bold;
        }
        .text-danger {
            font-size: 0.875rem;
            margin-top: 5px;
        }
        .alert {
            margin-top: 15px;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #f1ece4 !important;
        }
        .dropdown-menu {
            background-color: #d4a373 !important;
            border: none;
        }
        .dropdown-item {
            color: #fff !important;
        }
        .dropdown-item:hover {
            background-color: #c98d58 !important;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
    </style>
</head>
<body>
    <?php include 'adminnavbar.php'; ?>
    <div class="container mt-5">
        <h2>Add Product</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $field => $error): ?>
                        <li><?= htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form action="add_product_handler.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlspecialchars($old_data['product_name'] ?? ''); ?>" >
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= htmlspecialchars($old_data['price'] ?? ''); ?>" >
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id" style="height: 47px;">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['category_id']); ?>" <?= isset($old_data['category_id']) && $old_data['category_id'] == $category['category_id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image" style="height: 47px;">
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
            <div class="mt-3">
                <a href="products.php" class="btn btn-secondary">Back to Products</a>
            </div>
            <div class="mt-3">
            <a href="add_category.php" class="btn btn-secondary">Add New Category</a>
        </div>
        </div>
    </div>
</body>
</html>
