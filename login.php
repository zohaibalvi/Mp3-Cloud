<?php include('server.php') ?>
<!DOCTYPE html>
<html>

<head>

  <?php include('header.php') ?>

</head>

<body>

  <div class="limiter">
    <div class="container-login100" style="background-image: url('./images/2.jpg');">
      <div class="wrap-login100" style="height: 600px;">
        <form class="login100-form validate-form" method="post" action="login.php">
          <?php include('errors.php'); ?>
          <span class="login100-form-logo">
            <i class="zmdi zmdi-landscape"></i>
          </span>

          <span class="login100-form-title p-b-34 p-t-27">
            Log in
          </span>

          <div class="wrap-input100 validate-input" data-validate="Enter username">
            <input class="input100" type="text" name="username" placeholder="Username">
            <span class="focus-input100" data-placeholder="&#xf207;"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100" data-placeholder="&#xf191;"></span>
          </div>

          <div class="container-login100-form-btn">
            <button class="login100-form-btn" name="login_user">
              Login
            </button>
          </div>

          <div class="text-center p-t-20">
            <a class="txt1" href="register.php">
              Create a new account!
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include('javascript.php'); ?>
</body>

</html>