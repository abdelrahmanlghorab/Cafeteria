<?php
require"db.php";
$today = date('Y-m-d');
$stmt = $pdo->prepare("
    SELECT o.order_id, o.date, o.total_price,o.status,o.comment, u.user_name, u.room, u.Ext, 
           GROUP_CONCAT(CONCAT(p.product_name, ' x', oi.quantity, ' @ ', oi.price, ' LE') SEPARATOR ', ') AS items
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    WHERE DATE(o.date) = :today
    GROUP BY o.order_id
");
$stmt->execute(['today' => $today]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Today's Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f3e9;
            color: #333;
        }
        .navbar {
            background-color: #d4a373;
            margin-bottom: 20px;
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
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #d4a373;
        }
        table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    background-color: #fff; /* Background color of the table */
}

table th, table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #d4a373; /* Border color matching the theme */
}

table th {
    background-color: #d4a373; /* Header background color */
    color: #fff; /* Header text color */
    font-weight: 600; /* Slightly bolder font for the headers */
}

table tr:nth-child(even) {
    background-color: #f2f2f2; /* Alternate row background color */
}

table tr:nth-child(odd) {
    background-color: #f7f3e9; /* Matching page background color for odd rows */
}
        .btn-deliver {
            color: #fff;
            background-color: #8b4513;
            border-color: #8b4513;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-deliver:hover {
            background-color: #5a2d0c;
            border-color: #5a2d0c;
        }
        .item-row {
            background-color: #ffffff;
        }
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .item-details {
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php include 'adminnavbar.php'; ?>
    <div class="container">
        <h1>Today's Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Extension</th>
                    <th>Total Price</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders as $order): ?>
                    <tr <?php if ($order['status'] === 'completed'||$order['status'] === 'cancelled') echo 'style="display:none;"'; ?> >
                        <td><?php echo date('Y-m-d H:i:s', strtotime($order['date'])); ?></td>
                        <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['room']); ?></td>
                        <td><?php echo htmlspecialchars($order['Ext']); ?></td>
                        <td><?php echo htmlspecialchars($order['total_price']); ?> LE</td>
                        <td><?php echo htmlspecialchars($order['comment']); ?></td>
                        <td><a href="deliver_order.php?order_id=<?php echo $order['order_id']; ?>"class="btn-deliver">Deliver</a></td>
                    </tr>
                    <tr class="item-row" <?php if ($order['status'] === 'completed'||$order['status'] === 'cancelled') echo 'style="display:none;"'; ?>>
                        <td colspan="7">
                            <div class="item-details">
                                <table>
                                    <?php
                                    $itemStmt = $pdo->prepare("
                                        SELECT p.product_name, p.price, p.image, oi.quantity 
                                        FROM order_items oi
                                        JOIN products p ON oi.product_id = p.product_id
                                        WHERE oi.order_id = :order_id
                                    ");
                                    $itemStmt->execute(['order_id' => $order['order_id']]);
                                    $items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="item-image">
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($item['product_name']); ?> x<?php echo $item['quantity']; ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($item['price']); ?> LE
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
