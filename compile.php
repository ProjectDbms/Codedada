<?php
	include_once("includes/db_connection.php");
	include_once("api.php");
	// include("includes/header.php");
	if($_POST['type'] == 'run') {
		$config['source']=$_POST['code'];
		$config['input']=$_POST['input'];
		$config['language']=$_POST['lang'];
		$responseOfRun = run($hackerearth,$config);
		// print_r($responseOfRun);
		// if($responseOfRun["compile_status"] != "OK") {
		// 	echo $responseOfRun["compile_status"];
		// } else {
		// 	echo "".$responseOfRun["run_status"]["output_html"]."";
			
		// }
		echo json_encode($responseOfRun);
	}
?>