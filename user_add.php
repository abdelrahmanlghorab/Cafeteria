<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5cdf5dc; 
            color: #4b2e2e; 
        }
        h2 {
            color: #4b2e2e; 
        }
        .btn-primary {
            background-color: #8b4513; 
            border-color: #8b4513;
        }
        .btn-primary:hover {
            background-color: #5a2d0c; 
            border-color: #5a2d0c;
        }
        .form-control {
            border: 1px solid #4b2e2e; 
            background-color: #f5f5dc; 
            color: #4b2e2e; 
        }
        .form-group label {
            color: #4b2e2e; 
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
        <h2>Add User</h2>
        <form action="user_add_handler.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="user_name">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="room">Room</label>
                <input type="text" class="form-control" id="room" name="room">
            </div>
            <div class="form-group">
                <label for="Ext">Ext</label>
                <input type="text" class="form-control" id="Ext" name="Ext">
            </div>
            <div class="form-group">
                <label for="image">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group">
                <label for="role_id">Role ID</label>
                <input type="text" class="form-control" id="role_id" name="role_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
</body>
</html>
