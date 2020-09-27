<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  
  <?php include('header.php') ?>

</head>
<body>
  


  <div class="limiter">
		<div class="container-login100" style="background-image: url('./images/2.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="register.php">
				<?php include('errors.php'); ?>
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Sign Up
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate = "Enter mail">
						<input class="input100" type="text" name="email" value="<?php echo $email; ?>" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password_1" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Confirm password">
						<input class="input100" type="password" name="password_2" placeholder="Confirm Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="reg_user">
							Register
						</button>
					</div>

					<div class="text-center p-t-20">
						<a class="txt1" href="login.php">
							Already a member?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php include('javascript.php'); ?>
</body>
</html>