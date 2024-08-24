<?php
$errors = [];
$old_data = [];
$message = '';

if (isset($_GET['errors'])) {
    $errors = json_decode($_GET['errors'], true);
}
if (isset($_GET['old_data'])) {
    $old_data = json_decode($_GET['old_data'], true);
}
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="./images/logo.png" type="image/x-icon" >
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f3e9;
            color: #333;
            display: block; 
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin: 10% auto 0 auto;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #d4a373;
            text-align: center;
        }
        .form-control {
            border-radius: 20px;
            border: 1px solid #d4a373;
        }
        .btn {
            border-radius: 20px;
        }
        .btn-secondary {
            background-color: #d4a373;
            border-color: #d4a373;
        }
        .btn-secondary:hover {
            background-color: #c98d58;
            border-color: #c98d58;
        }
        .btn-primary {
            background-color: #8b4513;
            border-color: #8b4513;
        }
        .btn-primary:hover {
            background-color: #5a2d0c;
            border-color: #5a2d0c;
        }
        .text-danger {
            font-size: 0.875rem;
        }
        .form-text {
            text-align: center;
        }
        .alert {
            border-radius: 20px;
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
        </ul>
    </div>
</nav>


    <div class="login-container">
    <?php if ($errors): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errors; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>   
    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
        <h1>Login</h1>
        <form action="loginvalid.php" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($old_data['email'] ?? ''); ?>" required>
                <div class="invalid-feedback">Please enter your email</div>
                <span class="text-danger"><?php echo $errors['email'] ?? ''; ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($old_data['password'] ?? ''); ?>" required>
                <div class="invalid-feedback">Please enter your password</div>
                <span class="text-danger"><?php echo $errors['password'] ?? ''; ?></span>
            </div>
            <button type="submit" class="btn btn-secondary w-100 mb-2">Submit</button>
            <button type="reset" class="btn btn-primary w-100">Reset</button>
            <div class="form-text mt-3">
                <a href="signup.php" class="text-decoration-none">Sign Up</a> | 
                <a href="forget.php" class="text-decoration-none">Forgot Password?</a>
            </div>
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
