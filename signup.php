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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f3e9;
            color: #4b2e2e;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h2 {
            color: #d4a373;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 20px;
            border: 1px solid #d4a373;
            background-color: #f5f5dc;
            color: #4b2e2e;
        }
        .form-group label {
            color: #4b2e2e;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #d4a373;
            border-color: #d4a373;
            border-radius: 20px;
        }
        .btn-primary:hover {
            background-color: #c98d58;
            border-color: #c98d58;
        }
        .text-danger {
            font-size: 0.875rem;
        }
    </style>
</head>
<body> 
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup_handler.php" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="user_name">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo htmlspecialchars($old_data['user_name'] ?? ''); ?>" required>
                <div class="invalid-feedback">Please enter your user name</div>
                <span class="text-danger"><?php echo $errors['user_name'] ?? ''; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($old_data['email'] ?? ''); ?>" required>
                <div class="invalid-feedback">Please enter your email</div>
                <span class="text-danger"><?php echo $errors['email'] ?? ''; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">Please enter your password</div>
                <span class="text-danger"><?php echo $errors['password'] ?? ''; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="room">Room</label>
                <input type="text" class="form-control" id="room" name="room" value="<?php echo htmlspecialchars($old_data['room'] ?? ''); ?>" required>
                <div class="invalid-feedback">Please enter your room number</div>
                <span class="text-danger"><?php echo $errors['room'] ?? ''; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="Ext">Ext</label>
                <input type="text" class="form-control" id="Ext" name="Ext" value="<?php echo htmlspecialchars($old_data['Ext'] ?? ''); ?>" required>
                <div class="invalid-feedback">Please enter your extension</div>
                <span class="text-danger"><?php echo $errors['Ext'] ?? ''; ?></span>
            </div>
            <div class="form-group mb-4">
                <label for="image">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group mb-4">
                <input type="hidden" class="form-control" id="role_id" name="role_id" value="1">
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
