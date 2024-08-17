<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5dc; /* Light beige background */
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
            border: 1px solid #4b2e2e; /* Coffee brown border for inputs */
            background-color: #f5f5dc; /* Light beige input background */
            color: #4b2e2e; /* Coffee brown input text color */
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
        <h2>Add Category</h2>
        <form action="save_add_category.php" method="post">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
        <div class="mt-3">
            <a href="add_product.php" class="btn btn-secondary">Back to Add Product</a>
        </div>
    </div>
</body>
</html>
