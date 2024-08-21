<?php
$errors = [];
$old_data = [];
if (isset($_GET['errors'])) {
    $errors = json_decode($_GET['errors'], true);
}
if (isset($_GET['old_data'])) {
    $old_data = json_decode($_GET['old_data'], true);
}

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f3e9; 
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
    <div class="container mt-5">
        <h2>Add User</h2>
        <form action="signup_handler.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="user_name">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php $eval=isset($old_data['user_name'])?$old_data['user_name']:"";echo $eval;?>">
                <span class="text-danger"><?php $error=isset($errors['user_name'])? $errors['user_name']: ''; echo $error; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php $eval=isset($old_data['email'])?$old_data['email']:"";echo $eval;?>">
                <span class="text-danger"><?php $error=isset($errors['email'])? $errors['email']: ''; echo $error; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <span class="text-danger"><?php $error=isset($errors['password'])? $errors['password']: ''; echo $error; ?></span>
            </div>
            <div class="form-group">
                <label for="room">Room</label>
                <input type="text" class="form-control" id="room" name="room" value="<?php $eval=isset($old_data['room'])?$old_data['room']:"";echo $eval;?>">
                <span class="text-danger"><?php $error=isset($errors['room'])? $errors['room']: ''; echo $error; ?></span>
            </div>
            <div class="form-group">
                <label for="Ext">Ext</label>
                <input type="text" class="form-control" id="Ext" name="Ext" value="<?php $eval=isset($old_data['Ext'])?$old_data['Ext']:"";echo $eval;?>">
                <span class="text-danger"><?php $error=isset($errors['Ext'])? $errors['Ext']: ''; echo $error; ?></span>
            </div>
            <div class="form-group">
                <label for="image">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="role_id" name="role_id" value="1">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
</body>
</html>
