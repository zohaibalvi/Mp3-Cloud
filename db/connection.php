<?php

$host = '';
$db_name = '';
$db_user = ''; 
$db_password = '';
$conn = "";
if (!(empty($host) && empty($db_name) && empty($db_user) && empty($db_password) )){
	$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
}


// mysqli_close($conn);
?>