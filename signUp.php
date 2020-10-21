<!DOCTYPE html>
<html>
<head>
	<title>Codedada - SignUp</title>
	<?php
		include("includes/header.php");
	?>
	<link rel="stylesheet" href="assets/css/signUp.css?q=<?php echo time(); ?>" type="text/css">
</head>
<body>
	<div class="container-fluid">
		<div class="row container-main">
			<div class="col-md-6 col-xs-12 signup-card">
				
			</div>
			<div class="col-md-6">
				<div class="signup-form pr-5 pl-5">
					<form action="signUp.php" method="post" class="signup-form">
						<h2 class="mb-2" style="color: #004E7C;">Sign Up - <span style="color: red;">Codedada</span></h2>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email" required>
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" id="username" min="4" max="50" required>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password" id="password" min="4" max="20" required>
						</div>
						<div class="form-group">
							<label for="confirmPassword">Confirm Password</label>
							<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" min="4" max="20" required>
						</div>
						<p style="color: red;">Already have account? <span style="color: blue;"><a href="login.php">Login here</a></span></p>
						<div class="text-center">
							<input type="submit" name="signUp" value="Sign Up" class="btn btn-primary pr-3 pl-3">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>