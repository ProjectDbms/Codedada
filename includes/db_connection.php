<?php
	$conn = mysqli_connect('localhost', 'root', '', 'codedada_db');
	if(!$conn) {
		die("Connection to database failed: " . mysqli_connect_error());
	}
?>