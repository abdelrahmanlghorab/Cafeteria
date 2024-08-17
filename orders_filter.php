<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Admin - Checks</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f3e9;
            color: #333;
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
            color: #d4a373;
            font-weight: 500;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            transition: color 0.3s ease;
        }
        .user-orders:hover {
            color: #c98d58;
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
        .item img {
    width: 100px; 
    height: auto;
    margin-bottom: 10px;
    border-radius: 5px;
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
            <?php include 'get_orders.php'; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.user-orders').on('click', function() {
                $(this).next('.order-details').slideToggle();
            });
        });
    </script>
</body>
</html>
