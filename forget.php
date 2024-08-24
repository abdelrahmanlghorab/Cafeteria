<?php
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >
    <style>
        body {
            background-color: #f7f3e9;
            font-family: 'Poppins', sans-serif;
            display: block;
            height: 100vh;
            margin: 0;
        }
        .main-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin: 8% auto 0 auto;
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
        .form-label {
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
        .alert {
            border-radius: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #8b6139 !important; width: 100%; top: 0; z-index: 1000;">
    <div class="container">
        <ul class="navbar-nav me-auto">
            <li><a class="navbar-brand text-light" href="#">
                <img src="./images/logo.png" alt="cafeteria" width="45">
                Cafeteria
            </a></li>
            <li class="nav-item">
                <a class="nav-link text-light" href="signup.php">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="login.php">Login</a>
            </li>
        </ul>
    </div>
</nav>
<?php if (isset($message)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container main-container">
    <h2>Reset Password</h2>
    <form id="resetPasswordForm" action="forget_handler.php" method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="user_name" class="form-label">User Name</label>
            <input type="text" class="form-control" id="user_name" name="user_name" required>
            <div class="invalid-feedback">
                Please enter your user name.
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" required minlength="8">
            <div class="invalid-feedback">
                Password must be at least 8 characters long.
            </div>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required minlength="8">
            <div class="invalid-feedback">
                Passwords do not match.
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        'use strict'
        const form = document.getElementById('resetPasswordForm');

        form.addEventListener('submit', function (event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            if (password !== confirmPassword) {
                event.preventDefault();
                event.stopPropagation();
                document.getElementById('confirmPassword').classList.add('is-invalid');
            }

            form.classList.add('was-validated');
        }, false);
    })();
</script>

</body>
</html>
