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
    
<!-- <link rel="stylesheet" href="bootstrap/css/style.css" /> -->
<?php include('header.php'); ?>
</head>
<body>      

<div class="limiter">
		<div class="container-login100" style="background-image: url('./images/2.jpg');">
			<div class="wrap-login100">
      <?php  if (isset($_SESSION['username'])) : ?>
        <div class="container-login100-form-btn" style="justify-content: right !important;">
        <a href="upload.php?logout='1'" class="login100-form-btn"> Logout</a>
                </div>
                <p style="text-align: center; color: white;">Hello, <?php echo $_SESSION['username']; ?></strong></p>
                <?php endif ?>
                <div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      <p style="text-align: center; color: white;">
          <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
          ?>
        </p>
      </div>
    <?php endif ?>
      <form class="login100-form validate-form" method="post" action="upload.php" enctype="multipart/form-data">
				

					<span class="login100-form-title p-b-34 p-t-27">
						Upload Songs
					</span>
        
					<div class="wrap-input100 validate-input" data-validate = "Song title">
						<input class="input100" type="text" name="song_title" placeholder="song title">
						<span class="focus-input100" data-placeholder="&#xf133;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate = "File name">
						<input class="input100" type="text" name="file_name" placeholder="File name">
						<span class="focus-input100" data-placeholder="&#xf1c;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="File format">
						<input class="input100" type="text" name="file_format" placeholder="File format">
						<span class="focus-input100" data-placeholder="&#xf1ea;"></span>
                    </div>
                   
                    
                    <div class="wrap-input100 validate-input">
                        <label for="exampleFormControlFile1 " style="color: white;">Select a song</label>
                        <input type="file" class="" id="exampleFormControlFile1" name="fileToUpload" style="color: white;">
                      </div>

				

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="upload" data-toggle="modal" data-target=".bd-example-modal-sm">
							Upload
						</button>
					</div>

                    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content cmodal">
                            Song has been Uploaded!
                          </div>
                        </div>
                      </div>
				
				</form>
			</div>
		</div>
    </div>
    <?php include('javascript.php'); ?>
</body>
</html>
