<!DOCTYPE html>
<html>
<head>
    <title>Codedada - Login</title>
    <?php
        include("includes/header.php");
    ?>
    <link rel="stylesheet" href="assets/css/login.css?q=<?php echo time(); ?>" type="text/css">
</head>
<body>
    <div class="container">
        <div class="login-card-wrapper">
            <div class="card login-card">
                <div class="card-body">
                    <h2 class="login-card-title">Login</h2>
                    <p class="login-card-description">Sign in to your account to continue.</p>
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@example.com">
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password">Password</label>
                                <a href="#!" class="forgot-password-link">Forgot Password?</a>
                            </div>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <input name="login" id="login" class="btn login-btn" type="submit" value="Login">
                    </form>
                    <p class="login-card-footer-text" style="color: red;">Don't have an account? <a href="signUp.php" class="text-reset" style="color:blue !important;">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>