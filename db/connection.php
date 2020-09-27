<?php
// include ('./global_constant.php');
define('RDS_HOSTNAME','mp3.chvrcdwgvt0o.us-east-1.rds.amazonaws.com');
define('RDS_NAME','mp3');
define('RDS_USER','zohaib');
define('RDS_PASSWORD','syedzohaibali');
define('RDS_CLASS','db.t2.micro');
define('RDS_STORAGE', 5);
define('RDS_ENGINE','MySQL');
$host = RDS_HOSTNAME;
$db_name = RDS_NAME;
$db_user = RDS_USER; 
$db_password = RDS_PASSWORD;

$conn = mysqli_connect($host, $db_user, $db_password, $db_name);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
// echo "Host information: " . mysqli_get_host_info($conn) . PHP_EOL;



// mysqli_close($conn);
?>