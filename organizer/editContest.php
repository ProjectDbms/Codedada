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
		include("../includes/header.php");
	?>
	<link rel="icon" href="../assets/images/programming.png" type="image/png">
	<link rel="stylesheet" href="../assets/css/create.css?q=<?php echo time(); ?>" type="text/css">
	<?php
		if(isset($_GET["contestId"]) || isset($_POST["updateContest"])) {
			$contest_id = $_GET["contestId"];
			$sql = "SELECT * FROM contest WHERE contest_id='$contest_id'";
			$result = mysqli_query($conn, $sql);
			if(!$result) {
				echo "<script>window.alert('Connection error')</script>";
			}
			$contestRow = mysqli_fetch_assoc($result);
		} else {
			header("location: manage.php");
		}
		if(isset($_POST["updateContest"])) {
			$contest_id = $_POST['contestId'];
			$contest_name = $_POST['contest_name'];
			$description = $_POST['description'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$difficulty = $_POST['difficulty'];
			$username = $_SESSION['username'];
			$sql = "UPDATE contest SET contest_name='$contest_name', description='$description', start_time='$start_time', end_time='$end_time', difficulty='$difficulty' WHERE contest_id='$contest_id'";
			if(mysqli_query($conn, $sql)) {
				echo "<script>window.alert('Successfully updated');
				window.location.href='manage.php';
				</script>";
				// header("location: manage.php");
			} else {
				echo "<script>window.alert('Cannot Update');</script>";
				header("location: manage.php?contestId=$contest_id");
			}
		}
	?>
</head>
<body>
	<?php include("navbar.php"); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col col-md-3">
			</div>
			<div class="col col-md-6">
				<div class="contest-form">
					<h2>Update your contest</h2>
					<form action="editContest.php" method="post">
						<div class="form-group">
							<label for="contest_name">Contest Name</label>
							<input type="text" class="form-control" id="contest_name" name="contest_name" min="1" max="250" value="<?php echo $contestRow['contest_name']; ?>" required>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" id="description" name="description" rows="5" cols="30"><?php echo $contestRow['description']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="start_time">Start Time</label>
							<input type="datetime-local" class="form-control" id="start_time" name="start_time" value="<?php echo date("Y-m-d\TH:i",strtotime($contestRow['start_time'])); ?>" required>
						</div>
						<div class="form-group">
							<label for="end_time">End Time</label>
							<input type="datetime-local" class="form-control" id="end_time" name="end_time" value="<?php echo date("Y-m-d\TH:i",strtotime($contestRow['end_time'])); ?>" required>
						</div>
						<div class="form-group">
							<label for="difficulty">Difficulty</label>
							<select name="difficulty" id="difficulty" class="form-control">
								<option value="Easy">Easy</option>
								<option value="Medium">Medium</option>
								<option value="Difficult">Difficult</option>
							</select>
						</div>
						<input type="hidden" name="contestId" value="<?php echo $contest_id ?>">
						<input type="submit" name="updateContest" value="Update" class="btn btn-primary">
					</form>
				</div>
			</div>
			<!-- <div class="col col-md-3">
			</div> -->
		</div>

		<!-- <div class="row">
			<div class="col">

			</div>
		</div> -->
	</div>
	<script type="text/javascript">
	</script>
</body>
</html>