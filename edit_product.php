<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch existing product data
    $sql = "SELECT * FROM products WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

try {
    $stmt = $conn->prepare("SELECT category_id, category_name FROM categories");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
}

    // Initialize variables for errors and old data
    $errors = [];
    $old_data = [];

    // Retrieve errors and old data from query string
    if (isset($_GET['errors'])) {
        $errors = json_decode($_GET['errors'], true);
    }
    if (isset($_GET['old_data'])) {
        $old_data = json_decode($_GET['old_data'], true);
    }

    if ($product):
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Product</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="icon" href="./images/logo.png" type="image/x-icon" >
            <style>
                body {
                    background-color: #f7f3e9;
                    color: #4b2e2e;
                    font-family: Arial, sans-serif;
                }
                h2 {
                    color: #4b2e2e;
                    margin-bottom: 30px;
                }
                .form-container {
                    background-color: #ffffff;
                    padding: 40px;
                    border-radius: 15px;
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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
                .navbar {
                    background-color: #d4a373 !important;
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
                <h2>Edit Product</h2>
                <div class="form-container">
                    <form action="edit_product_handler.php?id=<?php echo urlencode($product_id); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars(isset($old_data['product_name']) ? $old_data['product_name'] : $product['product_name']); ?>" >
                            <?php if (isset($errors['product_name'])): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($errors['product_name']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars(isset($old_data['price']) ? $old_data['price'] : $product['price']); ?>" >
                            <?php if (isset($errors['price'])): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($errors['price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image" >
                            <img src="./images/<?php echo htmlspecialchars(isset($old_data['image']) ? $old_data['image'] : $product['image']); ?>" alt="Product Image" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                            <?php if (isset($errors['image'])): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($errors['image']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category ID</label>
                            


                            <select class="form-control" id="category_id" name="category_id" style="height: 47px;">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['category_id']); ?>" <?= isset($product['category_id']) && $product['category_id'] == $category['category_id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>


                            <?php if (isset($errors['category_id'])): ?>
                                <span class="text-danger"><?php echo htmlspecialchars($errors['category_id']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="is_available">Available</label>
                            <select class="form-control" id="is_available" name="is_available" style="height: 47px;">
                                <option value="1" <?php echo isset($old_data['is_available']) ? ($old_data['is_available'] ? 'selected' : '') : ($product['is_available'] ? 'selected' : ''); ?>>Yes</option>
                                <option value="0" <?php echo isset($old_data['is_available']) ? (!$old_data['is_available'] ? 'selected' : '') : (!$product['is_available'] ? 'selected' : ''); ?>>No</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="products.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
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
