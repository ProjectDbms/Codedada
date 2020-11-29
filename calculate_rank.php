<?php
	include("includes/db_connection.php");
	// $contest_id = $_POST['contestId'];
	// echo $contest_id;
	$contest_id = $_GET['contestId'];
	$par_sql = "SELECT * FROM participant WHERE contest_id=$contest_id";
	$par_result = mysqli_query($conn, $par_sql);
	$par_row = mysqli_fetch_all($par_result, MYSQLI_ASSOC);
	echo "<pre>";
	// print_r($par_row);
	echo "</pre>";
	$ques_sql = "SELECT * FROM question WHERE contest_id=$contest_id";
	$ques_result = mysqli_query($conn, $ques_sql);
	$ques_row = mysqli_fetch_all($ques_result, MYSQLI_ASSOC);
	echo "<pre>";
	// print_r($ques_row);
	echo "</pre>";

	foreach ($par_row as $participant) {
		// echo "<pre>";
		// print_r($participant);
		// echo "</pre>";
		$participant_id = $participant['participant_id'];
		$timeSize = 0;
		$sumTime = 0;
		$sumPoints = 0;
		$participant_sub_row = array();
		foreach($ques_row as $question) {
			// echo "<pre>";
			// print_r($question);
			// echo "</pre>";
			$question_id = $question['question_id'];
			$subm_sql = "SELECT submission.participant_id, submission.time_submitted, submission.question_id, submission.submission_id ,SUM(points) AS points FROM submission_verdict sv, submission WHERE sv.submission_id=submission.submission_id AND participant_id=$participant_id AND question_id=$question_id GROUP BY sv.submission_id ORDER BY points DESC, submission.time_submitted";
			$subm_result = mysqli_query($conn, $subm_sql);
			// $subm_row = mysqli_fetch_all($subm_result, MYSQLI_ASSOC);
			// echo "<pre>";
			// print_r($subm_row);
			// echo "</pre>";
			$max_points = 0;
			$time_submitted = 0;
			if(mysqli_num_rows($subm_result) > 0) {
				$subm_row = mysqli_fetch_all($subm_result, MYSQLI_ASSOC);
				// print_r($subm_row);	
				foreach ($subm_row as $sub_marks) {
					// print_r($sub_marks);
					if($sub_marks['points'] > $max_points || ($max_points==0 && $sub_marks['points']==0)) {
						$max_points = $sub_marks['points'];
						$time_submitted = $sub_marks['time_submitted'];
					}
				}
				$timeSize += 1;
			}
			$sumPoints += $max_points;
			$sumTime += strtotime($time_submitted);
			// echo $time_submitted."<br>";
		}
		// echo $sumTime."<br>";
		$avgDate = date("Y-m-d\TH:i:s", ceil($sumTime/$timeSize));
		// echo $avgDate;
		$account_id = $participant['account_id'];
		// echo $account_id;
		$acc_sql = "SELECT * FROM accounts WHERE account_id=$account_id";
		$acc_result = mysqli_query($conn, $acc_sql);
		$acc_row = mysqli_fetch_assoc($acc_result);
		$username = $acc_row['username'];
		// print_r($acc_result);

		$participant_sub_row['participant_id'] = $participant['participant_id'];
		$participant_sub_row['username'] = $username;
		$participant_sub_row['contest_id'] = $participant['contest_id'];
		$participant_sub_row['average_time'] = $avgDate;
		$participant_sub_row['points'] = $sumPoints;

		print_r($participant_sub_row);
	}
?>