<?php
include 'db_connect.php';


$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; 


$query = "SELECT o.order_id, o.date, o.total_price, o.status
          FROM orders o
          WHERE o.user_id = :user_id";

if (!empty($date_from)) {
    $date_from = date('Y-m-d', strtotime($date_from));
}
if (!empty($date_to)) {
    $date_to = date('Y-m-d', strtotime($date_to));
}

if (!empty($date_from) && !empty($date_to)) {
    $query .= " AND o.date BETWEEN :date_from AND :date_to";
}


$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
if (!empty($date_from) && !empty($date_to)) {
    $stmt->bindParam(':date_from', $date_from);
    $stmt->bindParam(':date_to', $date_to);
}
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($orders) > 0) {
    foreach ($orders as $order) {
        $status_class = '';
        $show_cancel_button = '';
        switch ($order['status']) {
            case 'pending':
                $status_class = 'status-processing';
                $show_cancel_button = "<button class='btn cancel-btn' data-order-id='{$order['order_id']}'>Cancel Order</button>";
                break;
            case 'delivery':
                $status_class = 'status-delivery';
                break;
            case 'done':
                $status_class = 'status-done';
                break;
        }

        echo "
            <div class='order-row'>
                <div class='d-flex justify-content-between align-items-center'>
                    <h4>Order ID: {$order['order_id']}</h4>
                    <div class='toggle-icon fas fa-plus'></div>
                </div>
                <p>Date: {$order['date']}</p>
                <p>Total Price: {$order['total_price']} LE</p>
                <p class='{$status_class}'>Status: " . ucfirst($order['status']) . "</p>
                <div class='order-details' style='display: none;'>
        ";

        
        $items_query = "
            SELECT p.product_name, p.image, oi.quantity, oi.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = :order_id
        ";
        $items_stmt = $conn->prepare($items_query);
        $items_stmt->bindParam(':order_id', $order['order_id']);
        $items_stmt->execute();
        $items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
            echo "
                <div class='item'>
                    <img src='images/{$item['image']}' alt='{$item['product_name']}' />
                    <div>{$item['product_name']}</div>
                    <div>Quantity: {$item['quantity']}</div>
                    <div>Price: {$item['price']} LE</div>
                </div>
            ";
        }

        echo "
                </div>
                {$show_cancel_button}
            </div>
        ";
    }
} else {
    echo '<div class="no-data">No orders found.</div>';
}
?>
