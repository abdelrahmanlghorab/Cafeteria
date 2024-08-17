<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
 if(empty($user_id)){
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f3e9;
            color: #333;
        }
        .order-row {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .order-row:hover {
            background-color: #f2e6d4;
        }
        .order-details {
            display: none;
            margin-left: 20px;
        }
        .order-items {
            margin-top: 10px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .item {
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .item img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }
        .item:hover {
            transform: translateY(-5px);
        }
        .no-data {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #6c757d;
        }
        h1 {
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .status-processing {
            color: #d4a373;
            font-weight: bold;
        }
        .status-delivery {
            color: #ffc107;
            font-weight: bold;
        }
        .status-done {
            color: #28a745;
            font-weight: bold;
        }
        .pagination {
            justify-content: center;
        }
        .cancel-btn {
            color: #dc3545;
            font-weight: bold;
            cursor: pointer;
        }
        .card-header {
            background-color: #d4a373;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 1.25rem;
        }
        .form-label {
            font-weight: 500;
            color: #6b705c;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: box-shadow 0.3s ease-in-out;
        }
        .form-control:focus {
            box-shadow: 0 0 8px rgba(212, 163, 115, 0.5);
            border-color: #d4a373;
        }
        .btn-primary {
            background-color: #d4a373;
            border-color: #d4a373;
            font-weight: 600;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #c98d58;
            border-color: #c98d58;
            transform: translateY(-2px);
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
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
<?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center">My Orders</h1>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Filter Orders
            </div>
            <div class="card-body">
                <form method="GET" id="filterForm" class="row g-3">
                    <div class="col-md-6">
                        <label for="date_from" class="form-label">Date from:</label>
                        <input type="date" name="date_from" id="date_from" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="date_to" class="form-label">Date to:</label>
                        <input type="date" name="date_to" id="date_to" class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-3">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="orderData">
            <?php include 'get_user_orders.php'; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            $('.order-row').on('click', function() {
                const details = $(this).find('.order-details');
                details.slideToggle();

                const icon = $(this).find('.toggle-icon');
                if (icon.hasClass('fa-plus')) {
                    icon.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    icon.removeClass('fa-minus').addClass('fa-plus');
                }
            });

            $('.cancel-btn').on('click', function(e) {
                e.stopPropagation(); 
                const orderId = $(this).data('order-id');
                if (confirm("Are you sure you want to cancel this order?")) {
                    $.ajax({
                        type: 'POST',
                        url: 'cancel_order.php',
                        data: { order_id: orderId },
                        success: function(response) {
                            alert(response);
                            location.reload(); 
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
