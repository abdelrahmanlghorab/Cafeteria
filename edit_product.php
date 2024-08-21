<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    
    $sql = "SELECT * FROM products WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product):
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Product</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    background-color: #f7f3e9; 
                    color: #4b2e2e; 
                }
                h2 {
                    color: #4b2e2e; 
                }
                .btn-primary {
                    background-color: #8b4513; 
                    border-color: #8b4513;
                }
                .btn-primary:hover {
                    background-color: #5a2d0c; 
                    border-color: #5a2d0c;
                }
                .btn-secondary {
                    background-color: #d2b48c; 
                    border-color: #d2b48c;
                }
                .btn-secondary:hover {
                    background-color: #a89b73; 
                    border-color: #a89b73;
                }
                .form-control {
                    border: 1px solid #4b2e2e; 
                    background-color: #f5f5dc; 
                    color: #4b2e2e; 
                }
                .form-group label {
                    color: #4b2e2e; 
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
                <h2>Edit Product</h2>
                <form action="edit_product_handler.php?id=<?php echo $product_id; ?>" method="post">
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category ID</label>
                        <input type="number" class="form-control" id="category_id" name="category_id" value="<?php echo $product['category_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="is_available">Available</label>
                        <select class="form-control" id="is_available" name="is_available">
                            <option value="1" <?php echo $product['is_available'] ? 'selected' : ''; ?>>Yes</option>
                            <option value="0" <?php echo !$product['is_available'] ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="products.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </body>
        </html>
<?php
    else:
        echo "Product not found.";
    endif;
} else {
    echo "Invalid request.";
}
?>
