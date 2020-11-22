<!DOCTYPE html>
<html lang="en">
<head>
<title>Codedada - Contest</title>
	<?php
		session_start();
		include_once("includes/db_connection.php");
		if(!(isset($_SESSION["username"]))) {
			header("location: login.php");
		}
        include("includes/header.php");
        $contest_id = $_GET['contestId'];
    echo $_SESSION["is_registered_$contest_id"];
    ?>
</head>
<body>
    
</body>
</html>