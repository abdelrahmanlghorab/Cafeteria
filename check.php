<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Admin - Checks</title>
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
        h1 {
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .card-header {
            background-color: #d4a373;
            font-weight: bold;
            font-size: 1.25rem;
        }
        .card-body {
            background-color: #ffffff;
            padding: 30px;
        }
        .btn-primary {
            background-color: #d4a373;
            border-color: #d4a373;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #c98d58;
            border-color: #c98d58;
        }
        .form-label {
            font-weight: 500;
            color: #6b705c;
        }
        .user-orders {
            cursor: pointer;
            color: #333;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
            background-color : #d4a373;
        }
        .user-orders:hover {
            background-color: #ffe2c6;
        }
        .order-details {
            display: none;
            padding: 10px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }
        .order-items {
            display: none;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .item {
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fa;
            margin-bottom: 10px;
        }
        .item img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }
        .item:hover {
            background-color: #f1ece4;
        }
        .order{
            cursor: pointer;
            color: #333;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
            background-color : #f7f3e9;
            display: flex;
            justify-content: space-between;
            
        }
        .order:hover {
            background-color: #ffe2c6;
        }
        .order-items {
            display: none;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;

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
    <!-- Navbar -->
    <?php include 'adminnavbar.php'; ?>
    <div class="container">
        <h1>Checks</h1>
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Filter Orders
            </div>
            <div class="card-body">
                <form method="GET" id="filterForm" class="row g-3">
                    <div class="col-md-4">
                        <label for="date_from" class="form-label">Date from:</label>
                        <input type="date" name="date_from" id="date_from" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="date_to" class="form-label">Date to:</label>
                        <input type="date" name="date_to" id="date_to" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="user" class="form-label">User:</label>
                        <select name="user" id="user" class="form-select">
                            <option value="">All Users</option>
                            <!-- Populate users from the database -->
                            <?php
                            include 'db_connect.php';
                            $users_query = "SELECT user_id, user_name FROM users";
                            $users_result = $conn->query($users_query);
                            while ($user = $users_result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$user['user_id']}'>{$user['user_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="orderData">
            <!-- This section will be populated with PHP -->
            <?php include 'get_orders.php'; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.user-orders', function() {
        $(this).next('.order-details').slideToggle();
    });

    // Toggle order items when clicking on an order
    $(document).on('click', '.table-row', function() {
        $(this).next('.order-items').slideToggle();
    });
    $(document).on('click', '.order', function() {
    // Slide up any currently visible .order-items
    $('.order-items').not($(this).find('.order-items')).slideUp();
    // Toggle the .order-items of the clicked .order
    $(this).find('.order-items').slideToggle();
});

        });
    </script>
</body>
</html>
