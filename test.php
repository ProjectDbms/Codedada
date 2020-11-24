<?php
	$myfile = fopen("code.txt", "r") or die("Unable to open file!");
	// echo fread($myfile,filesize("code.txt"));
	$q = fread($myfile,filesize("code.txt"));
	echo $q;
	fclose($myfile);
?>