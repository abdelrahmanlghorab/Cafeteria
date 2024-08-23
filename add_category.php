<?php 

$errors = [];
$old_data = [];
if (isset($_GET['errors'])) {
    $errors = json_decode($_GET['errors'], true);
}
if (isset($_GET['old_data'])) {
    $old_data = json_decode($_GET['old_data'], true);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >
    <style>
        body {
            background-color: #f9f4ef; /* Light beige background */
            color: #4b2e2e; /* Coffee brown text color */
        }
        h2 {
            color: #4b2e2e; /* Coffee brown heading color */
        }
        .btn-primary {
            background-color: #8b4513; /* Saddle brown button */
            border-color: #8b4513;
        }
        .btn-primary:hover {
            background-color: #5a2d0c; /* Darker brown on hover */
            border-color: #5a2d0c;
        }
        .btn-secondary {
            background-color: #d2b48c; /* Tan for secondary button */
            border-color: #d2b48c;
        }
        .btn-secondary:hover {
            background-color: #b8860b; /* Darker tan on hover */
            border-color: #b8860b;
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
        .form-container{
            margin-top: 100px;
            margin-bottom: 100px;
            margin-left: 100px;
            margin-right: 100px;
            border-radius: 10px;
            padding: 20px;
            background-color: #f5f5dc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container .form-group {
            margin-bottom: 20px;
        }
        .form-container .form-control {
            border-radius: 10px;
            padding: 15px;
            transition: border-color 0.3s ease;
        }
        .form-container .form-control:focus {
            border-color: #8b4513;
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }
        
    </style>
</head>
<body>
    <?php include 'adminnavbar.php'; ?>
    <div class="container mt-5">
        <h2>Add Category</h2>
        <?php if (! empty($errors)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" >
        <?php echo htmlspecialchars($errors['category_name']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
        <form action="save_add_category.php" method="post" class="form-container">
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" >
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
            <a href="add_product.php" class="btn btn-secondary back-btn">Back to Add Product</a>
        </form>
        
    </div>
</body>
</html>
