<?php

require './vendor/autoload.php';
include ('./db/connection.php');
// include ('./global_constant.php');
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

session_start();


//constant
define('AWS_ACCESS_KEY_ID', 'ASIAVNIXFW6W3SZXZWMD');
define('AWS_SECRET_ACCESS_KEY', 'OuKnknO91SphcGe0PaQfM8s6CsVf6ZhWfvskJBub');
define('TOKEN', 'FwoGZXIvYXdzEEwaDAIPbgsbSm91DPY9XSLVASNx4o8bikkbXluTrIFRMFm9Vhdn/9ULxBPefCMqoS/EXZv1DfeDdditnxMphAkVoDDJvcB8dZ9ADiwyAa5G/hp6em6rfkAQW/KVmiRxBCQBjIAfrOFjJBc2ROfF7zBEe3WmXBvJ8DoJjUT0MR99dJmBRACmT03kvj/uGSWMhKwzI6ZlcLngCUQ911lqhEN+ITn+x7I7qKedjbJm9gvZSULwt/lccPFw9dwIqXJtOTuckEpD7BeLxHYYBOag3uif0EQ+71KjaKjobJmi1JkPxwDrZ9X8UCjKn9P7BTItXAq+uVSiiELfzgv4NVsDX/lkmxz4RmxuRokrECO7e59hiSC8/xAW+JbaM/BZ');



define('BUCKET_NAME', 'zohaib');
define('REGION', 'us-east-1');
define('DESKTOP_PATH', 'C:/Users/user/Desktop');


//db configuration

define('RDS_HOSTNAME','mp3.chvrcdwgvt0o.us-east-1.rds.amazonaws.com');
define('RDS_NAME','mp3');
define('RDS_USER','zohaib');
define('RDS_PASSWORD','syedzohaibali');
define('RDS_CLASS','db.t2.micro');
define('RDS_STORAGE', 5);
define('RDS_ENGINE','MySQL');

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
// $conn = mysqli_connect('localhost', 'root', '', 'mp3');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);


  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($conn, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: upload.php');
  }
}
// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($conn, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: upload.php');
    }else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}



// upload 
if (isset($_POST['upload'])) {
  $file_path = $_FILES["fileToUpload"]["tmp_name"];
  $path = $_FILES['fileToUpload']['name'];
  // echo "<br>";
  $file_format = pathinfo($path, PATHINFO_EXTENSION);

  // receive all input values from the form
  $song_title = mysqli_real_escape_string($conn, $_POST['song_title']);
  $file_name = mysqli_real_escape_string($conn, $_POST['file_name']);
  $file_format = $file_format; 


  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($song_title)) { array_push($errors, "Username is required"); }
  if (empty($file_name)) { array_push($errors, "file name is required"); }
  if (empty($file_format)) { array_push($errors, "file format is required"); }
  

  // Finally, register user if there are no errors in the form

  if (count($errors) == 0) {

    $query = "INSERT INTO upload_songs (song_title, file_name, file_format) 
          VALUES('$song_title', '$file_name', '$file_format')";
    mysqli_query($conn, $query);

     uploadFileIntoS3($file_path,$_POST['file_name'].'.'.$file_format);

    header('location: upload.php');
  }
}


// upload file on s3 bucket
function uploadFileIntoS3($file_path,$file_name){

$argv = array(BUCKET_NAME,$file_path);

if (count($argv) < 2) {
    echo $USAGE;
    exit();
}

$bucket = $argv[0];
$file_path = $argv[1];
$key = $file_name;   

try {

$credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);


$s3 = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => REGION,
    'credentials' => $credentials
]);

    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key' => $key,
        'SourceFile' => $file_path,
        'ACL'    => 'public-read',


    ]);
  
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}
}
?>