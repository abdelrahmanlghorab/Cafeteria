<?php
$errors = [];
$old_data = [];
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
    <title>login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f3e9;
            color: #333;
        }
        
    </style>
</head>
<body>
<?php if($message){ echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
   $message
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>
        ";}
        ?>


<div class="container mt-5 mb-5">
    <h1 class="text-center">login</h1>
    <form action="loginvalid.php" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
    <span class="text-danger"><?php $error=isset($errors['login'])? $errors['login']: ''; echo $error; ?></span>
        <div class="form-group">
            <label for="name">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php $eval=isset($old_data['email'])?$old_data['email']:"";echo $eval;?>" required>
            <div class="invalid-feedback">Please enter your email</div>
            <span class="text-danger"><?php $error=isset($errors['email'])? $errors['email']: ''; echo $error; ?></span>
        </div>
        <div class="form-group">
            <label for="name">Password:</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php $eval=isset($old_data['password'])?$old_data['password']:"";echo $eval;?>" required>
            <div class="invalid-feedback">Please enter your Password</div>
            <span class="text-danger"><?php $error=isset($errors['password'])? $errors['password']: ''; echo $error; ?></span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
        <div class="text-center mt-3">
        <a href="signup.php" class="btn btn-link">Signup</a>
        or
        <a href="forget.php" class="btn btn-link">Forget Password</a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>

