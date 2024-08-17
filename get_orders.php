<?php
include 'db_connect.php';

$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$user_id = isset($_GET['user']) ? $_GET['user'] : '';

$where_clause = "WHERE 1=1";

if (!empty($date_from)) {
    $where_clause .= " AND o.date >= :date_from";
}
if (!empty($date_to)) {
    $where_clause .= " AND o.date <= :date_to";
}
if (!empty($user_id)) {
    $where_clause .= " AND o.user_id = :user_id";
}

$query = "
    SELECT u.user_id, u.user_name, SUM(o.total_price) AS total_amount
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    $where_clause
    GROUP BY u.user_id, u.user_name
";

$stmt = $conn->prepare($query);

if (!empty($date_from)) {
    $stmt->bindParam(':date_from', $date_from);
}
if (!empty($date_to)) {
    $stmt->bindParam(':date_to', $date_to);
}
if (!empty($user_id)) {
    $stmt->bindParam(':user_id', $user_id);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    $user_id = $row['user_id'];
    echo "
        <div>
            <div class='user-orders'>
                <span>{$row['user_name']}</span> - Total amount: {$row['total_amount']}
            </div>
            <div class='order-details'>
    ";

    $order_query = "
        SELECT o.order_id, o.date, o.total_price
        FROM orders o
        WHERE o.user_id = :user_id
    ";

    if (!empty($date_from)) {
        $order_query .= " AND o.date >= :date_from";
    }
    if (!empty($date_to)) {
        $order_query .= " AND o.date <= :date_to";
    }

    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bindParam(':user_id', $user_id);

    if (!empty($date_from)) {
        $order_stmt->bindParam(':date_from', $date_from);
    }
    if (!empty($date_to)) {
        $order_stmt->bindParam(':date_to', $date_to);
    }

    $order_stmt->execute();
    $order_results = $order_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($order_results as $order_row) {
        echo "
            <div>
                <span>Order Date: {$order_row['date']}</span> - Amount: {$order_row['total_price']}
                <div class='order-items'>
        ";

        $items_query = "
            SELECT p.product_name, p.image, oi.quantity, oi.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = :order_id
        ";
        $items_stmt = $conn->prepare($items_query);
        $items_stmt->bindParam(':order_id', $order_row['order_id']);
        $items_stmt->execute();
        $items_results = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items_results as $item_row) {
            echo "
                <div class='item'>
                    <img src='images/{$item_row['image']}' alt='{$item_row['product_name']}' />
                    <div>{$item_row['product_name']}</div>
                    <div>Qty: {$item_row['quantity']}</div>
                    <div>Price: {$item_row['price']} LE</div>
                </div>
            ";
        }

        echo "
                </div> <!-- end of .order-items -->
            </div> <!-- end of order -->
        ";
    }

    echo "
            </div> <!-- end of .order-details -->
        </div>
    ";
}
?>
