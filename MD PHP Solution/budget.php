<?php require_once("include/functions/config.php"); ?>
<?php require_once("include/functions/functions.php"); ?>
<?php session_start(); ?>
<?php if ( !isLoggedIn() ) { $_SESSION['feedback'] = ['color' => 'red', 'message' =>'Please login to view that page.']; header("Location: /index.php"); die; } ?>

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Bobby Craig">
    <meta name="description" content="A budgeting application for use at Denison University.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Budgeting Portal | buDUget</title>

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

    <?php require("include/which-styles.php"); ?>

  </head>

  <body>

    <div class="full-modal">

      <?php require("include/nav-sidebar.php"); ?>

      <?php require("include/header.php"); ?>

      <div class="partial-modal">

        <?php require("include/sidebar.php"); ?>

        <?php require("include/sub-header.php"); ?>

        <div class="main">

          <div class="content" style="<?php if ( isFinanceCommittee() ) { echo 'padding-top: 8em'; } else { echo 'padding-top: 4em'; } ?>">

            <?php require("include/event-card.php"); ?>

            <?php require("include/expenditure-card.php") ?>

          </div> <!-- End content -->

        </div> <!-- End main -->

      </div>

    </div>

<!-- JavaScript at the end of the page so it loads faster. -->

    <?php require("include/which-js.php"); ?>

<!-- End JavaScript -->

  </body>

</html>
