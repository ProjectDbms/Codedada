<!DOCTYPE html>
<html>
<head>
	<title>Codedada - Manage Contest</title>
	<?php
		session_start();
		include("../includes/db_connection.php");
		if(!(isset($_SESSION["username"]))) {
			header("location: ../login.php");
		}
		$username = $_SESSION["username"];
		// $sql = "SELECT * FROM contest NATURAL JOIN accounts WHERE username='$username'";
		$sub_sql = "SELECT account_id from accounts WHERE username='$username'";
		$result = mysqli_query($conn, $sub_sql);
		
		$row = mysqli_fetch_assoc($result);
		
		$account_id = $row['account_id'];
		$sql = "SELECT * FROM contest WHERE account_id=$account_id";
		$result = mysqli_query($conn, $sql);
		$contests = mysqli_fetch_all($result, MYSQLI_ASSOC);
		include("../includes/header.php");
	?>
	<link rel="stylesheet" href="../assets/css/create.css?q=<?php echo time(); ?>" type="text/css">
</head>
<body>
	<?php include("navbar.php"); ?>
	<div class="container-fluid">
		<div class="my-contests">
			<h2>My Contests</h2>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Contest Name</th>
						<th>Description</th>
						<th>Start time</th>
						<th>End time</th>
						<th colspan="2">Buttons</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($contests as $contest) {?>
				<tr>
					<td><?php echo $contest['contest_name'] ?></td>
					<td><?php echo $contest['description'] ?></td>
					<td><?php
							$stt = strtotime($contest['start_time']);
							echo date("d-m-Y h:i:s a", $stt)
						?>
					</td>
					<td><?php 
							$stt = strtotime($contest['end_time']);
							echo date("d-m-Y h:i:s a", $stt)
						?>
					</td>
					<td><button class="btn btn-primary">Edit</button></td>
					<td><button class="btn btn-primary">Delete</button></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<hr>
	</div>
	<script type="text/javascript">
		// activate("nav2");
	</script>
</body>
</html>