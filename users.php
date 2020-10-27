<!DOCTYPE html>
<html>
<head>
	<title>Codedada - Users</title>
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
		<div class="row">
			<div class="col col-xs-7 col-md-8" style="background-color: lightblue;">
				fd
			</div>
			<div class="col col-xs-5 col-md-4" style="background-color: lightgreen;">
				dff
			</div>
		</div>
	</div>
	<script type="text/javascript">
		activate("nav3");
	</script>
</body>
</html>