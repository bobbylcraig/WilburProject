<?php require_once("include/functions/config.php"); ?>
<?php require_once("include/functions/functions.php"); ?>
<?php require_once("include/functions/preserveViewing.php"); ?>
<?php session_start(); ?>
<?php if ( isLoggedIn() ) { header("Location: budget.php"); die; } ?>

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Bobby Craig">
    <meta name="description" content="A budgeting application for use at Denison University.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>buDUget</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="#">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#">
    <meta name="apple-mobile-web-app-title" content="Title">
    <link rel="apple-touch-icon-precomposed" href="#">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="#">
    <meta name="msapplication-TileColor" content="#color">

    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="css/front-page.css">

  </head>

  <body>

    <?php require("include/notice.php"); ?>
    <div class="pen-title">
      <h1>buDUget</h1>
    </div>
    <div class="container">
      <div class="card"></div>
      <div class="card">
        <h1 class="title">Login</h1>
        <form action="include/functions/login.php" method="post">
          <div class="input-container">
            <input type="text" id="Username" name="username" required="required"/>
            <label for="Username">Username</label>
            <div class="bar"></div>
          </div>
          <div class="input-container">
            <input type="password" id="Password" name="password" required="required"/>
            <label for="Password">Password</label>
            <div class="bar"></div>
          </div>
          <div class="button-container">
            <button><span>Login</span></button>
          </div>
        </form>
      </div>
      <div class="card alt">
        <div class="toggle"></div>
        <h1 class="title">Forgot Password?
          <div class="close"></div>
        </h1>
        <form>
          <div class="input-container">
            <input type="text" id="Email" required="required"/>
            <label for="Email">Email</label>
            <div class="bar"></div>
          </div>
          <div class="button-container">
            <button><span>Submit</span></button>
          </div>
        </form>
      </div>
    </div>

<!-- JavaScript at the end of the page so it loads faster. -->

    <?php require("include/which-js.php"); ?>
    <script>
      $('.toggle').on('click', function() {
        $('.container').stop().addClass('active');
      });

      $('.close').on('click', function() {
        $('.container').stop().removeClass('active');
      });
    </script>

<!-- End JavaScript -->

  </body>

</html>
