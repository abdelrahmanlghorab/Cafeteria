<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f3e9; 
            color: #4b2e2e; 
        }
        h2 {
            color: #4b2e2e; 
        }
        .btn-success {
            background-color: #d4a373;
            border-color: #d4a373;
            font-weight: 600;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        .btn-success:hover {
            background-color: #5a2d0c; 
            border-color: #5a2d0c;
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
        .btn-danger {
            background-color: #cc3300; 
            border-color: #cc3300;
        }
        .btn-danger:hover {
            background-color: #992600; 
            border-color: #992600;
        }
        .table {
            background-color: #fff8e1; 
        }
        .table thead th {
            background-color: #d2b48c; 
            color: #4b2e2e; 
        }
        .table tbody tr {
            background-color: #f5f5dc; 
        }
        .table tbody tr:hover {
            background-color: #e0c097; 
        }
        img {
            border-radius: 5px; 
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
    <?php include 'adminnavbar.php'; ?>
    <div class="container mt-5">
        <h2>Users</h2>

        
        <div class="mb-3">
            <a href="user_add.php" class="btn btn-success">Add User</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Room</th>
                    <th>Ext</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                
                $sql = "SELECT * FROM users";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($users as $user):
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['room']); ?></td>
                        <td><?php echo htmlspecialchars($user['Ext']); ?></td>
                        <td><img src="./images/<?php echo htmlspecialchars($user['image']); ?>" alt="<?php echo htmlspecialchars($user['user_name']); ?>" width="50"></td>
                        <td>
                            <a href="user_edit.php?id=<?php echo $user['user_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="user_delete.php?id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>
