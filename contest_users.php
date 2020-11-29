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
		if(isset($_GET['contestId'])) {
			$contest_id = $_GET['contestId'];
		} else {
			header('location: contest.php');
		}
	?>
	<link rel="stylesheet" href="assets/css/index.css?q=<?php echo time(); ?>" type="text/css">
</head>
<body>
	<?php include("includes/navbar_contest.php"); ?>
	<div class="container-fluid main">
		<?php
			
		?>
	</div>
	<script type="text/javascript">
		activate("nav3");
	</script>
</body>
</html>