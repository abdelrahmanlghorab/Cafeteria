<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    
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
            background-color: #d4a373;
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
            height: 100%;
            width: 100%;
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
    <?php include 'navbar.php'; ?>
<div class="container mt-5">
    <div class="row">
   
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title">Place Your Order</h2>
                    <form method="POST" action="submit_order_user.php?user_id=<?php echo $user_id; ?>">
                        <div id="order-items" class="mb-3">
                            
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="comment" id="notes" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="room" class="form-label">Room</label>
                            <select name="room" id="room" class="form-select">
                                <?php
                               
                                $stmt = $pdo->query("SELECT DISTINCT room FROM users WHERE room IS NOT NULL");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['room']}'>{$row['room']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <p>Total: <span id="total-price" class="fw-bold">EGP 0</span></p>
                        </div>

                        <button type="submit" id="confirm-btn" class="btn btn-primary w-100">Confirm</button>
                    </form>
                </div>
            </div>
        </div>


<div class="col-md-6">
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="card-title">Latest Order</h2>
            <div class="latest-order mb-4">
    <?php

    $stmt = $pdo->query("
        SELECT orders.order_id, orders.total_price, orders.date, products.product_name, products.image, order_items.quantity, order_items.price
        FROM orders
        JOIN order_items ON orders.order_id = order_items.order_id
        JOIN products ON order_items.product_id = products.product_id
        WHERE orders.user_id = $user_id
        ORDER BY orders.date DESC
        LIMIT 1
    ");

    if ($stmt->rowCount() > 0) {
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $order = $orderDetails[0];

        echo "<h5>Order ID: {$order['order_id']}</h5>";
        echo "<p>Date: " . date('d M Y, h:i A', strtotime($order['date'])) . "</p>";
        echo "<p>Total: EGP {$order['total_price']}</p>";

        echo "<div class='order-items'>";
        foreach ($orderDetails as $item) {
            echo "<div class='card mb-2'>";
            echo "<div class='row g-0'>";
            echo "<div class='col-3'>";
            echo "<img src='images/{$item['image']}' class='img-fluid rounded-start' alt='{$item['product_name']}' style='border-radius: 10px;
            height: 100%;
            width: 100%;
            object-fit: cover;
       '>";
            echo "</div>";
            echo "<div class='col-9'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$item['product_name']}</h5>";
            echo "<p class='card-text'>Quantity: {$item['quantity']}</p>";
            echo "<p class='card-text'>Price: EGP " . number_format($item['price'], 2) . "</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No recent orders found.</p>";
    }
    ?>
</div>

            <h2 class="card-title">Products</h2>
            <div class="row row-cols-2 g-3">
                <?php
                
                $stmt = $pdo->query("SELECT * FROM products");
                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if($product['is_available'] == 1) {
                    echo "<div class='col'>";
                    echo "<div class='card product' data-id='{$product['product_id']}' data-name='{$product['product_name']}' data-price='{$product['price']}'>";
                    echo "<img src='images/{$product['image']}' class='card-img-top img-fluid' alt='{$product['product_name']}' style='border-radius: 10px;
            height: 100%;
            width: 100%;
            object-fit: cover;
       '>";
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
