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
    <link rel="stylesheet" href="style.css">
    <style>
    	body{
    		background-color:#f7f3e9;
    	}
        .container {
            max-width: 500px;
            margin-top: 100px;
        }
    </style>
</head>
<body>
<?php if($message){ echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    $message
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
        ";}
        ?>
<div class="container">
    <h2 class="text-center">Reset Password</h2>
    <form id="resetPasswordForm" action="forget_handler.php" method="POST">
    <div class="mb-3">
            <label for="text" class="form-label">User Name</label>
            <input type="text" class="form-control" id="text" name="user_name" required>
            <div class="invalid-feedback">
                Password must be at least 8 characters long.
            </div>
    </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" required >
            <div class="invalid-feedback">
                Password must be at least 8 characters long.
            </div>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required >
            <div class="invalid-feedback">
                Passwords do not match.
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
            event.preventDefault();
            document.getElementById('confirmPassword').classList.add('is-invalid');
        }
    });
</script>

</body>
</html>
