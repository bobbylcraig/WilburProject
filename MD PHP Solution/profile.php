<?php session_start(); ?>
<?php require_once("include/functions/config.php"); ?>
<?php require_once("include/functions/functions.php"); ?>
<?php require_once("include/functions/preserveViewing.php"); ?>
<?php if ( !isLoggedIn() ) { $_SESSION['feedback'] = ['color' => 'red', 'message' =>'Please login to view that page.']; header("Location: /index.php"); die; } ?>

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Bobby Craig">
    <meta name="description" content="A budgeting application for use at Denison University.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?php if ( !isFinanceCommittee() ) { echo grabCurrentScreenname(); ?>'s Profile<?php } else { ?> Admin Controls <?php } ?> | buDUget</title>

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

    <?php require("include/nav-sidebar.php"); ?>

    <?php require("include/profile/header.php"); ?>
    <?php require("include/profile/sub-header.php"); ?>

    <div class="main" style="margin-left: 0;">
      <div class="content" style="padding-top: <?php if (isAdmin()) { ?>8<?php } else { ?>4<?php } ?>em;">
        <div class="content-area">
          <div class="grid">
            <div class="tile desktop-12 tablet-12">
              <h1><?php echo grabCurrentScreenname(); ?>'s Profile</h1>
            </div>
            <?php if ( isAdmin() ) {
                    require("include/profile/isAdmin.php");
                  }
                  elseif ( canEdit() ) {
                    require("include/profile/isOrg.php");
                  }
                  else { ?>
                    <div class="tile desktop-12 tablet-12">
                      <h1>Sorry! Finance Committee doesn't have a profile!</h1>
                    </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

<!-- JavaScript at the end of the page so it loads faster. -->

    <?php require("include/which-js.php"); ?>

<!-- End JavaScript -->

  </body>

</html>
