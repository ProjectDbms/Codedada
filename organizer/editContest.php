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
		if(isset($_POST["updateQuestion"])) {
			$contest_id = $_POST['contest_id'];
			$question_id = $_POST['question_id'];
			$question_name = $_POST['question_name'];
			$question_description = $_POST['question_description'];
			$level = $_POST['level'];
			$del_sql = "DELETE FROM testcase WHERE question_id=$question_id";
			$testcase_inputs = $_POST['testcase_input'];
			$testcase_outputs = $_POST['testcase_output'];
			$points = $_POST['points'];
			if(!mysqli_query($conn, $del_sql)) {
				echo "<script>
					window.alert('Database error in deleting');
					window.location.href = 'editContest.php?contestId=$contest_id';
				</script>";
			}

			$update_sql = "UPDATE question SET question_description='$question_description', question_name='$question_name', level='$level' WHERE question_id=$question_id";
			if(!mysqli_query($conn, $update_sql)) {
				echo "<script>
					window.alert('Database error in updating');
					window.location.href = 'editContest.php?contestId=$contest_id';
				</script>";
			}

			$i=0;
			foreach($testcase_inputs as $testcase_input) {
				if($testcase_outputs[$i] != '' || $testcase_inputs[$i] != '') {
					$tes_sql = "INSERT INTO testcase(question_id, testcase_input, testcase_output, points) VALUES($question_id, '$testcase_inputs[$i]', '$testcase_outputs[$i]', $points[$i])";
					if(!mysqli_query($conn, $tes_sql)) {
						echo "<script>
							window.alert('Database error in entering testcases');
							window.location.href = 'editContest.php?contestId=$contest_id';
						</script>";
					}
				}
				$i += 1;
			}
			echo "<script>
					window.alert('Successfully updated');
					window.location.href = 'editContest.php?contestId=$contest_id';
				</script>";
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
			} else {
				echo "<script>window.alert('Cannot Update');</script>";
				header("location: manage.php?contestId=$contest_id");
			}
		}
		if(isset($_GET["contestId"]) || isset($_POST["updateContest"]) || isset($_POST["updateQuestion"])) {
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
		</div>
	</div>
	<div class="container-fluid mt-2">
		<?php
			$q_sql = "SELECT * FROM question WHERE contest_id=$contest_id";
			$q_result = mysqli_query($conn, $q_sql);
			$questions = mysqli_fetch_all($q_result, MYSQLI_ASSOC);
		?>
		<h3>Questions</h3>
		<table class="table table-bordered">
			<thead class="thead-dark">
				<th>Question title</th>
				<th>Question</th>
				<th>Level</th>
				<th>Points</th>
			</thead>
			<tbody>
				<?php foreach($questions as $question) { ?>
					<?php
						$question_id = $question['question_id'];
						$question_name = $question['question_name'];
						$question_desc = $question['question_description'];
						$level = $question['level'];
						$testcase_sql = "SELECT * FROM testcase WHERE question_id=$question_id";
						$testcase_result = mysqli_query($conn, $testcase_sql);
						$testcases = mysqli_fetch_all($testcase_result, MYSQLI_ASSOC);
						$points = 0;
						foreach($testcases as $testcase) {
							$points += $testcase['points'];
						}
					?>
					<tr>
						<td>
							<a href="" data-toggle="modal" data-target="#question<?php echo $question_id ?>ModalLong"><?php echo $question_name ?></a>

							<!-- Modal -->
							<div class="modal fade" id="question<?php echo $question_id ?>ModalLong" tabindex="-1" role="dialog" aria-labelledby="question<?php echo $question_id ?>ModalLongTitle" aria-hidden="true">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="question<?php echo $question_id ?>ModalLongTitle">Edit <?php echo $question_name ?></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="editContest.php" method="post">
											<div class="modal-body">
											<!-- ... -->
												<input type="hidden" name="question_id" value="<?php echo $question_id ?>">
												<input type="hidden" name="contest_id" value="<?php echo $contest_id ?>">
												<div class="form-group">
													<label>Question title</label>
													<input type="text" class="form-control" name="question_name" value="<?php echo $question_name ?>" required>
												</div>
												<div class="form-group">
													<label>Question description</label><br>
													<textarea name="question_description" id="" cols="50" rows="4" class="form-control" required><?php echo $question_desc ?></textarea>
												</div>
												<div class="form-group">
													<select name="level" class="form-control" required>
														<option value="Easy">Easy</option>
														<option value="Medium">Medium</option>
														<option value="Hard">Hard</option>
													</select>
												</div>
												<div class="form-group">
													<h3>Testcases</h3>
													<p class="alert alert-info">Leave the fields empty and points as 0 for to delete the testcase</p>
													<?php $index=1; foreach($testcases as $testcase) { ?>
														<p class="text-info font-weight-bold">Testcase <?php echo $index ?></p>
														<label>Testcase Input</label><br>
														<textarea name="testcase_input[]" cols="50" rows="3" class="form-control"><?php echo $testcase['testcase_input'] ?></textarea><br>
														<label>Testcase Output</label><br>
														<textarea name="testcase_output[]" cols="50" rows="3" class="form-control"><?php echo $testcase['testcase_output'] ?></textarea><br>
														<label>Points</label><br>
														<input type="number" name="points[]" class="form-control" value="<?php echo $testcase['points'] ?>" required><br><br>
													<?php $index += 1; } ?>
													<div class="add-testcase">

													</div>
													<script type="text/javascript">
														$('.add-tcase-btn').click(function(event) {
															event.preventDefault();
															// var e = $(this);
															// var title = e.data('title');
															// var body = e.data('value');
															// $('.modal-title').html(title);
															// $('.modal-body').html(body);
															// $('#question<?php //echo $question_id ?>ModalLong').modal('show');

															var t="<p class='text-danger font-weight-bold'>New Testcase</p>";
															t += "<label>Testcase Input</label><br>";
															t += "<textarea name='testcase_input[]' cols='50' rows='3' class='form-control'></textarea><br>";
															t += "<label>Testcase Output</label><br>";
															t += "<textarea name='testcase_output[]' cols='50' rows='3' class='form-control'></textarea><br>";
															t += "<label>Points</label><br>";
															t += "<input type='number' name='points[]' class='form-control' required><br><br>";
															$(".add-testcase").append(t);
															$("#question<?php echo $question_id ?>ModalLong").click();

														});
													</script>
												</div>
											</div>
											<div class="modal-footer">
												<button class="add-tcase-btn btn btn-warning">Add Testcase</button>
												<input type="hidden" id="qId" value="<?php echo $question_id ?>">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" name="updateQuestion" class="btn btn-primary">Save changes</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</td>
						<td><?php echo $question_desc ?></td>
						<td><?php echo $level ?></td>
						<td><?php echo $points ?></td>
						<!-- <td> -->
							<!-- Button trigger modal -->
							<!-- Edit -->
						<!-- </td> -->
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="container-fluid mt-2">
		<form action="">

		</form>
	</div>
</body>
</html>

