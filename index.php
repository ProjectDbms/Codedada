<!DOCTYPE html>
<html>
<head>
	<title>Codedada</title>
	<?php
		session_start();
		if(!(isset($_SESSION["username"]))) {
			header("location: login.php");
		}
		include("includes/header.php");
	?>
	<link rel="stylesheet" href="assets/css/index.css?q=<?php echo time(); ?>" type="text/css">
</head>
<body>
	<div class="container-fluid">
		<?php include("includes/navbar.php"); ?>
	</div>
</body>
</html>