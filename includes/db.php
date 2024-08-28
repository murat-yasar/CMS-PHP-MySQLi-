<?php

$db_host = 'localhost';
$db_user = 'root';
$db_password = 'root';
$db_name = 'cms-php';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$conn->set_charset("utf8");

// echo "DB Connected";

// Check connection
!$conn && die("Connection failed: " . mysqli_connect_error());