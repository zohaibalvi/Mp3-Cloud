<?php 
 include('server.php');
  // session_start(); 

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    // print_r("expression");exit;
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
<link rel="stylesheet" href="bootstrap/css/style.css" />
</head>
<body>

<div class="header">
    <h2>Upload Songs</h2>
    <br>
    <?php  if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p> <a href="upload.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>
<div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
        <h3>
          <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
          ?>
        </h3>
      </div>
    <?php endif ?>

<form method="post" action="register.php">
   
    <div class="input-group">
      <label>Song Title</label>
      <input type="text" name="song_title">
    </div>
    <div class="input-group">
      <label>File Name</label>
      <input type="text" name="file_name" >
    </div>
    <div class="input-group">
      <label>File Format</label>
      <input type="text" name="file_format">
    </div>
    <div class="input-group">
      <label>Upload Song </label>
      <input type="file" name="upload_song">
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="upload">Upload</button>
    </div>
   
  </form>


    <!-- logged in user information -->
    
</div>
        
</body>
</html>
