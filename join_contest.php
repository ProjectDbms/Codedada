<?php
    session_start();
    $contest_id = $_GET['contestId'];
    echo $_SESSION["is_registered_$contest_id"];
?>