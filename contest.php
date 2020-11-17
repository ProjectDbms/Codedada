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
		$sql = "SELECT * FROM contest ORDER BY start_time DESC";
		$result = mysqli_query($conn, $sql);
		$contests = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$futureFlag = true;
	?>
	<link rel="stylesheet" href="assets/css/index.css?q=<?php echo time(); ?>" type="text/css">
	<link rel="stylesheet" href="assets/css/timeTo.css?q=<?php echo time(); ?>" type="text/css">
	<script type="text/javascript" src="assets/js/jquery-time-to.js"></script>
	<script type="text/javascript">
		function futureClock(startTime, contestId) {
			$("#futureClock"+contestId).timeTo({
			    timeTo: new Date(new Date(startTime)),
			    theme: "black",
			    displayCaptions: true,
			    fontSize: 20,
			    captionSize: 11
			});
		}
	</script>
</head>
<body>
	<?php include("includes/navbar.php"); ?>
	<div class="container-fluid main">
		<div class="future-contest mt-5">
			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>Contest name</th>
						<th>Organizer</th>
						<th>Start time</th>
						<th>End time</th>
						<th>Commences on</th>
						<th>Register</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($contests as $contest) { ?>
						<?php if (strtotime($contest['start_time']) > time()) { $futureFlag=false; ?>
							<tr>
								<td>
									<?php echo $contest["contest_name"] ?>
								</td>
								<td>
									<?php 
										$acc_id = $contest["account_id"];
										$sql = "SELECT username FROM accounts WHERE account_id=$acc_id";
										$result = mysqli_query($conn, $sql);
										$organizer = mysqli_fetch_assoc($result);
										echo $organizer["username"];
									?>
								</td>
								<td>
									<?php
										$sttime = $contest["start_time"];
										$entime = $contest["end_time"];
										$diff=strtotime($entime) - strtotime($sttime);
										echo date("d-m-Y h:i:s a", strtotime($sttime))."<br>";
										// echo date("d-m-Y h:i:s a", strtotime($entime))."<br>";
										$years = floor($diff / (365*60*60*24));
										$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
										$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
										$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
										$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
										$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
										// echo $years." year(s) ".$months." month(s) ".$days." day(s) ".$hours." hour(s) ".$minutes." min(s) ".$seconds." second(s)";
									?>
								</td>
								<td>
									<?php
										echo date("d-m-Y h:i:s a", strtotime($entime))."<br>";
									?>
								</td>
								<td>
									<div id="futureClock<?php echo $contest['contest_id'] ?>"></div>
									<?php
										$future_contest_id = $contest['contest_id'];
										$future_start_time = date("M d Y h:i:s", strtotime($sttime))." UTC+5:30";
										echo "<script>futureClock('$future_start_time', $future_contest_id);</script>";
									?>
								</td>
								<td>
									<a href="contest.php?join=<?php echo $contest['contest_id'] ?>">Register</a>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="past-contest mt-5">
			<table class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>Contest name</th>
						<th>Organizer</th>
						<th>Start time</th>
						<th>Duration</th>
						<th>Ranks</th>
						<th>Users</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($contests as $contest) { ?>
						<?php if (strtotime($contest['end_time']) < time()) { ?>
							<tr>
								<td>
									<?php echo $contest["contest_name"] ?>
								</td>
								<td>
									<?php 
										$acc_id = $contest["account_id"];
										$sql = "SELECT username FROM accounts WHERE account_id=$acc_id";
										$result = mysqli_query($conn, $sql);
										$organizer = mysqli_fetch_assoc($result);
										echo $organizer["username"];
									?>
								</td>
								<td>
									<?php
										$sttime = $contest["start_time"];
										$entime = $contest["end_time"];
										$diff=strtotime($entime) - strtotime($sttime);
										echo date("d-m-Y h:i:s a", strtotime($sttime))."<br>";
									?>
								</td>
								<td>
									<?php
										$years = floor($diff / (365*60*60*24));
										$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
										$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
										$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
										$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
										$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
										$hours = $hours>9?$hours:"0$hours";
										$minutes = $minutes>0?$minutes:"00";
										echo $hours." : ".$minutes;
									?>
								</td>
								<td>
									Ranks
								</td>
								<td>
									Users
								</td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		activate("nav2");
	</script>
	<?php
		if($futureFlag) {
			echo '<script>
				$(".future-contest").css("display", "none");
			</script>';
		}
	?>
	<script type="text/javascript">

	</script>
</body>
</html>