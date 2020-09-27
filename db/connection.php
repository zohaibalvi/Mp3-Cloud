<?php

$host = 'mp3.chvrcdwgvt0o.us-east-1.rds.amazonaws.com';
$db_name = 'mp3';
$db_user = 'zohaib'; 
$db_password = 'syedzohaibali';

$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}



// mysqli_close($conn);
?>