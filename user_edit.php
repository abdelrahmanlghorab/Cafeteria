<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5dc;
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
        .btn-secondary {
            background-color: #d2b48c; 
            border-color: #d2b48c;
        }
        .btn-secondary:hover {
            background-color: #a89b73; 
            border-color: #a89b73;
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
<body>
    <?php include 'adminnavbar.php'; ?>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <?php
        include 'db_connect.php';

        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];

            
            $sql = "SELECT * FROM users WHERE user_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user){
        ?>
        <form action="user_edit_handler.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($user['image']); ?>">
            
            <div class="form-group">
                <label for="user_name">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <div class="form-group">
                <label for="room">Room</label>
                <input type="text" class="form-control" id="room" name="room" value="<?php echo htmlspecialchars($user['room']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Ext">Ext</label>
                <input type="text" class="form-control" id="Ext" name="Ext" value="<?php echo htmlspecialchars($user['Ext']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">User Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <?php //if (!empty($user['image'])): ?>
                    <!--<img src="/images/<?php echo htmlspecialchars($user['image']); ?>" alt="<?php echo htmlspecialchars($user['user_name']); ?>" width="100">-->
                <?php // endif; ?>
            </div>
            <div class="form-group">
                <label for="role_id">Role</label>
                <select class="form-control" id="role_id" name="role_id">
                    
                    <?php
                    $roles = $conn->query("SELECT * FROM role")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($roles as $role) {
                        $selected = $role['id'] == $user['role_id'] ? 'selected' : '';
                        echo "<option value='{$role['id']}' $selected>{$role['permission']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </form>
        <?php
            } else {
                echo "User not found.";
            }
        } else {
            echo "Invalid request.";
        }
        ?>
    </div>
</body>
</html>
