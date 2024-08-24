<?php include 'db.php'; 
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >

   
      <style>
        body {
            background-color: #f9f4ef;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #d4a373;
            font-weight: bold;
            text-transform: uppercase;
        }

        .form-label {
            color: #6c757d;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #6b4226;
            border-color: #6b4226;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #8e562e;
            border-color: #8e562e;
        }

        #total-price {
            color: #6b4226;
            font-size: 1.5rem;
        }

        .navbar {
            color: #fff;
        }

        .navbar .nav-link {
            color: #fff;
            font-weight: bold;
            margin-right: 15px;
            transition: color 0.3s ease;
        }

        .navbar .dropdown-menu {
            background-color: #f9f4ef;
            border: none;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .dropdown-item {
            color: #6b4226;
        }

        .navbar .dropdown-item:hover {
            background-color: #d4a373;
            color: #fff;
        }

        .product img {
            
            border-radius: 10px;
            height: 300px !important;
            width:100%;
            object-fit: cover;
       
        }

        .card-body.text-center h5 {
            color: #6b4226;
        }

        .card-body.text-center p {
            color: #d4a373;
            font-weight: bold;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-controls button {
            border: none;
            background: none;
            font-size: 1.5rem;
            color: #6b4226;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .quantity-controls button:hover {
            color: #8e562e;
        }

        .quantity-controls input {
            width: 50px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            padding: 5px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .order-item img {
            border-radius: 5px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
        }

        .order-item .details {
            flex-grow: 1;
        }

        .order-item .details h6 {
            margin: 0;
            color: #6b4226;
        }

        .order-item .details p {
            margin: 0;
            color: #d4a373;
        }

        .order-item .controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .primary{
        background-color: #b77740;
        color:#fff;
        }
    </style>
</head>
<body>
 <?php include 'adminnavbar.php'; ?>
<div class="container mt-5">
    <div class="row">
       
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
            <?php if (isset($message)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
                <div class="card-body">
                    <h2 class="card-title">Place Your Order</h2>
                    <form method="POST" action="submit_order_admin.php">
                        
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select name="user_id" id="user_id" class="form-select">
                                <?php
                         
                                $stmt = $pdo->query("SELECT user_id, user_name FROM users");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['user_id']}'>{$row['user_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div id="order-items" class="mb-3">
                        
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="comment" id="notes" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <p>Total: <span id="total-price" class="fw-bold">EGP 0</span></p>
                            <input type="hidden" name="total_price" id="total_price_input" value="0">
                        </div>

                        <button type="submit" id="confirm-btn" class="btn primary w-100">Confirm</button>
                    </form>
                </div>
            </div>
        </div>

      
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title">Products</h2>
                    <div class="row row-cols-2 g-3">
                        <?php
                 
                        $stmt = $pdo->query("SELECT * FROM products");
                        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            if($product['is_available'] == 1) {
                            echo "<div class='col'>";
                            echo "<div class='card product' data-id='{$product['product_id']}' data-name='{$product['product_name']}' data-price='{$product['price']}'>";
                            echo "<img src='images/{$product['image']}' class='card-img-top img-fluid' alt='{$product['product_name']}' style='height: 100px; object-fit: cover;'>";
                            echo "<div class='card-body text-center'>";
                            echo "<h5 class='card-title'>{$product['product_name']}</h5>";
                            echo "<p class='card-text'>EGP {$product['price']}</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }}
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const products = document.querySelectorAll('.product');
    const orderItemsContainer = document.getElementById('order-items');
    let totalPrice = 0;

    products.forEach(product => {
        product.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = parseFloat(this.getAttribute('data-price'));

            let orderItem = document.querySelector(`#order-item-${productId}`);
            if (orderItem) {
                const quantityInput = orderItem.querySelector('.quantity-   ');
                quantityInput.value = parseInt(quantityInput.value) + 1;
            } else {
                orderItem = document.createElement('div');
                orderItem.classList.add('order-item');
                orderItem.setAttribute('id', `order-item-${productId}`);
                orderItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">${productName}</h5>
                            <p class="mb-1">Price: EGP ${productPrice}</p>
                        </div>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(${productId}, -1)">-</button>
                            <input type="text" name="products[${productId}][quantity]" class="quantity-input" value="1" readonly style="width: 40px; text-align: center;">
                            <input type="hidden" name="products[${productId}][price]" value="${productPrice}">
                            <button type="button" class="quantity-btn" onclick="updateQuantity(${productId}, 1)">+</button>
                        </div>
                    </div>
                `;
                orderItemsContainer.appendChild(orderItem);
            }

            totalPrice += productPrice;
            updateTotalPrice();
        });
    });

    window.updateQuantity = function(productId, change) {
        const orderItem = document.querySelector(`#order-item-${productId}`);
        if (!orderItem) return;

        const quantityInput = orderItem.querySelector('.quantity-input');
        let quantity = parseInt(quantityInput.value);
        quantity += change;

        if (quantity < 1) {
            orderItem.remove();
        } else {
            quantityInput.value = quantity;
        }

        const productPrice = parseFloat(orderItem.querySelector('input[name^="products"][name$="[price]"]').value);
        totalPrice += productPrice * change;
        updateTotalPrice();
    };

    function updateTotalPrice() {
        document.getElementById('total-price').innerText = `EGP ${totalPrice.toFixed(2)}`;
        document.getElementById('total_price_input').value = totalPrice.toFixed(2);
    }
});
</script>

</body>
</html>

