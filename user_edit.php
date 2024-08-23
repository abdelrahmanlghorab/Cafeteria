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
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >
    <style>
        body {
            background-color: #f7f3e9;
            color: #4b2e2e;
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #4b2e2e;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            border: 1px solid #4b2e2e;
            border-radius: 10px;
            background-color: #f5f5dc;
            color: #4b2e2e;
            padding: 15px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #8b4513;
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }
        .form-group label {
            color: #4b2e2e;
            font-weight: 600;
        }
        .text-danger {
            font-size: 0.875rem;
            margin-top: 5px;
        }
        .btn-primary {
            background-color: #8b4513;
            border-color: #8b4513;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #5a2d0c;
            border-color: #5a2d0c;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #f1ece4 !important;
        }
        .dropdown-menu {
            background-color: #d4a373 !important;
            border: none;
        }
        .dropdown-item {
            color: #fff !important;
        }
        .dropdown-item:hover {
            background-color: #c98d58 !important;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
    </style>
</head>
<body>
    <?php include 'adminnavbar.php'; ?>  
    <div class="container mt-5">
        <div class="form-container">
            <h2>Edit User</h2>
            <?php
            include 'db_connect.php';

            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];

                $sql = "SELECT * FROM users WHERE user_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['id' => $user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Merge user data with old data if available
                    $data = array_merge($user, $old_data);
            ?>
            <form action="user_edit_handler.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($data['user_id']); ?>">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($data['image']); ?>">

                <div class="form-group">
                    <label for="user_name">User Name</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo isset($data['user_name']) ? htmlspecialchars($data['user_name']) : ''; ?>">
                    <span class="text-danger"><?php echo isset($errors['user_name']) ? htmlspecialchars($errors['user_name']) : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>">
                    <span class="text-danger"><?php echo isset($errors['email']) ? htmlspecialchars($errors['email']) : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-text text-muted">Leave blank to keep current password.</small>
                    <span class="text-danger"><?php echo isset($errors['password']) ? htmlspecialchars($errors['password']) : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="room">Room</label>
                    <input type="text" class="form-control" id="room" name="room" value="<?php echo isset($data['room']) ? htmlspecialchars($data['room']) : ''; ?>">
                    <span class="text-danger"><?php echo isset($errors['room']) ? htmlspecialchars($errors['room']) : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="Ext">Ext</label>
                    <input type="text" class="form-control" id="Ext" name="Ext" value="<?php echo isset($data['Ext']) ? htmlspecialchars($data['Ext']) : ''; ?>">
                    <span class="text-danger"><?php echo isset($errors['Ext']) ? htmlspecialchars($errors['Ext']) : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control" id="role_id" name="role_id">
                        <option value="1" <?php echo $data['role_id'] == 1 ? 'selected' : ''; ?>>Admin</option>
                        <option value="2" <?php echo $data['role_id'] == 2 ? 'selected' : ''; ?>>User</option>
                    </select>
                    <span class="text-danger"><?php echo isset($errors['role_id']) ? htmlspecialchars($errors['role_id']) : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="image">Profile Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <?php if (!empty($data['image'])): ?>
                        <img src="./images/<?php echo htmlspecialchars($data['image']); ?>" alt="Profile Image" width="100" height="100">
                    <?php endif; ?>
                    <span class="text-danger"><?php echo isset($errors['image']) ? htmlspecialchars($errors['image']) : ''; ?></span>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="users.php" class="btn btn-secondary">Cancel</a>
            </form>
            <?php
                } else {
                    echo "<p>User not found.</p>";
                }
            } else {
                echo "<p>Invalid request.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
