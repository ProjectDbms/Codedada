<!DOCTYPE html>
<html>
<head>
	<title>Codedada - Submission</title>
	<?php
		session_start();
		include_once("includes/db_connection.php");
		if(!(isset($_SESSION["username"]))) {
			header("location: login.php");
		}
        include("includes/header.php");
        if(isset($_POST['code'])) {
        	include_once("api.php");
        	echo "<pre>";
        	// print_r($_POST);
        	echo "</pre>";
        	$contest_id = $_POST['contest_id'];
        	$question_id = $_POST['question_id'];
        	$code = $_POST['code'];
        	$lang = $_POST['language'];
        	$q_sql = "SELECT * FROM question WHERE contest_id=$contest_id AND question_id=$question_id";
	        $q_result = mysqli_query($conn, $q_sql);
	        if($q_result) {
	        	$question = mysqli_fetch_assoc($q_result);
	        	$tc_sql = "SELECT * FROM testcase WHERE question_id=$question_id";
				$ts_result = mysqli_query($conn, $tc_sql);
				$testcases = mysqli_fetch_all($ts_result, MYSQLI_ASSOC);
				$total_points = 0;
				$outputs = array();
				$verdicts = array();
				$points = array();
				$config['source'] = $code;
				$config['language'] = $lang;
				if($lang == 'C' || $lang == 'CPP14') {
					$myfile = fopen("code.txt", "r") or die("Unable to open file!");
					$config['source'] = fread($myfile,filesize("code.txt"));
					fclose($myfile);
				}
				foreach ($testcases as $testcase) {
					$testcase_input = $testcase['testcase_input'];
					$testcase_output = $testcase['testcase_output'];
					$testcase_output = trim($testcase_output);
					$testcase_points = $testcase['points'];
					$config['input'] = $testcase_input;
					$responseOfRun = run($hackerearth,$config);
					if($responseOfRun['compile_status'] != 'OK') {
						$verdicts[] = 'CE';
						$outputs[] = $responseOfRun['compile_status'];
						$points[] = 0;
					} else {
						$tempOut = $responseOfRun["run_status"]["output"];
						$tempOut = trim($tempOut);
						if($tempOut == $testcase_output) {
							$verdicts[] = 'AC';
							$outputs[] = $tempOut;
							$points[] = $testcase_points;
							$total_points += $testcase_points;
						} else {
							$verdicts[] = 'WA';
							$outputs[] = $tempOut;
							$points[] = 0;
						}
					}
				}
	        } else {
	        	echo "<script>console.log('Error');</script>";
	        }
        }
        ?>
</head>
<body>
	<?php if(isset($_POST['code'])) { ?>
		<?php
		/*$outputs = array('Hel', 'Error in parjd djdk jkjd :; aif h jpo kfodkfpkg[ fsdojf fpdok');
		$verdicts = array('WA', 'CE');
		$points = array(5, 5);
		$question["question_name"] = "Hello, World";*/
		?>
		<div class="container">
			<ul class="list-group">
				<h3><?php echo $question["question_name"]; ?></h3>
				<?php $i=0; foreach($outputs as $output) { ?>
					<?php if($verdicts[$i] == 'AC') { ?>
						<li class="list-group-item list-group-item-success"><?php echo "Test-".($i+1) ?> : AC Points:<?php echo $points[$i]; ?></li>
					<?php } else if($verdicts[$i] == 'WA') { ?>
						<li class="list-group-item list-group-item-danger"><?php echo "Test-".($i+1) ?> : WA Points:<?php echo $points[$i]; ?></li>
					<?php } else { ?>
						<li class="list-group-item list-group-item-danger"><?php echo "Test-".($i+1) ?> : <b>CE</b><br><?php echo $outputs[$i]; ?></li>
					<?php } ?>
				<?php $i+=1; } ?>
			</ul>
		</div>
	<?php } elseif(0) { ?>

	<?php } ?>
</body>
</html>