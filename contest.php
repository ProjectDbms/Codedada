<!DOCTYPE html>
<html>
<head>
	<title>Codedada - Contest</title>
	<?php
		session_start();
		include("includes/db_connection.php");
		if(!(isset($_SESSION["username"]))) {
			header("location: login.php");
		}
		include("includes/header.php");
	?>
	<link rel="stylesheet" href="assets/css/index.css?q=<?php echo time(); ?>" type="text/css">
</head>
<body>
	<?php include("includes/navbar.php"); ?>
	<div class="container-fluid main">
		
	</div>
	<script type="text/javascript">
		activate("nav2");
	</script>
</body>
</html>