<?php
require "db.php";

// Define how many results per page
$results_per_page = 3;

// Find out the number of orders
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_orders FROM orders");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_orders = $row['total_orders'];

// Determine the number of total pages available
$number_of_pages = ceil($total_orders / $results_per_page);

// Determine which page number visitor is currently on
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure the page number is at least 1

// Determine the starting limit number
$starting_limit = ($page - 1) * $results_per_page;

// Retrieve the orders with LIMIT
$stmt = $pdo->prepare("
    SELECT o.order_id, o.date, o.total_price, o.status, u.user_name, u.room, u.Ext, 
           GROUP_CONCAT(CONCAT(p.product_name, ' x', oi.quantity, ' @ ', oi.price, ' LE') SEPARATOR ', ') AS items
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.product_id
    GROUP BY o.order_id
    ORDER BY o.date DESC
    LIMIT :starting_limit, :results_per_page
");
$stmt->bindParam(':starting_limit', $starting_limit, PDO::PARAM_INT);
$stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
$stmt->execute();
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
    background-color: #d4a373 !important;
    color: #fff;
    font-weight: 600;
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
        .pagination {
            justify-content: center;
        }
        .pagination .page-link {
    color: #d4a373; /* Default link color */
    background-color: #f7f3e9; /* Background color to match the page */
    border: 1px solid #d4a373; /* Border color matching the theme */
}

.pagination .page-link:hover {
    color: #ffffff; /* Text color on hover */
    background-color: #d4a373; /* Background color on hover */
    border-color: #d4a373; /* Border color on hover */
}

.pagination .page-item.active .page-link {
    color: #ffffff; /* Active link text color */
    background-color: #8b4513; /* Active link background color */
    border-color: #8b4513; /* Active link border color */
}

.pagination .page-item.disabled .page-link {
    color: #c98d58; /* Disabled link color */
    background-color: #f7f3e9; /* Disabled link background color */
    border-color: #d4a373; /* Disabled link border color */
}
    </style>
</head>
<body>
    <?php include 'adminnavbar.php'; ?>
    <div class="container">
        <h1>ALL Orders</h1>
        <table class="table">
            <thead>
  <tr>
                    <th>Order Date</th>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Extension</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders as $order): ?>
                    <tr >
                        <td><?php echo date('Y-m-d H:i:s', strtotime($order['date'])); ?></td>
                        <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['room']); ?></td>
                        <td><?php echo htmlspecialchars($order['Ext']); ?></td>
                        <td><?php echo htmlspecialchars($order['total_price']); ?> LE</td>
                    </tr>
                    <tr class="item-row">
                        <td colspan="6">
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

        <!-- Pagination Controls -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $number_of_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
</html>

