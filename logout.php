<!DOCTYPE html>
<html>
<head>
	<title>Codedada - Logout</title>
	<?php
		include("includes/header.php");
		if(!isset($_SESSION["username"])) {
			header("location:login.php");
		}
		session_start();
		session_destroy();
	?>
</head>
<body>
	<div class="text-center">
		<h1 class="alert alert-success">Logout Successful</h1>
	</div>
</body>
</html>