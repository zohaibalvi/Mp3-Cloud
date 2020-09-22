<?php
include ('aws/s3.php');
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'mp3');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


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
  $result = mysqli_query($db, $user_check_query);
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
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: upload.php');
  }
}
// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
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
  echo "<br>";
$file_format = pathinfo($path, PATHINFO_EXTENSION);

  // receive all input values from the form
  $song_title = mysqli_real_escape_string($db, $_POST['song_title']);
  $file_name = mysqli_real_escape_string($db, $_POST['file_name']);
  $file_format = $file_format; //mysqli_real_escape_string($db, $_POST['file_format']);


  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($song_title)) { array_push($errors, "Username is required"); }
  if (empty($file_name)) { array_push($errors, "file name is required"); }
  if (empty($file_format)) { array_push($errors, "file format is required"); }
  

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {

    $query = "INSERT INTO upload_songs (song_title, file_name, file_format) 
          VALUES('$song_title', '$file_name', '$file_format')";
    mysqli_query($db, $query);

// print_r($_FILES);
// exit;
     uploadFileIntoS3($file_path,$_POST['file_name'].'.'.$file_format);

    // $_SESSION['song_title'] = $username;
    // $_SESSION['success'] = "You are now logged in";
    header('location: upload.php');
  }
}

?>