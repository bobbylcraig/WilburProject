<?php session_start(); ?>
<?php require_once("include/functions/config.php"); ?>
<?php require_once("include/functions/functions.php"); ?>
<?php if ( isLoggedIn() ) { require_once("include/functions/preserveViewing.php"); } ?>

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Bobby Craig">
    <meta name="description" content="A budgeting application for use at Denison University.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Analytics | buDUget</title>

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

    <?php require("include/analytics/nav-sidebar.php"); ?>

    <?php require("include/analytics/header.php"); ?>

    <div class="main" style="margin-left: 0; margin-top: 4em;">
      <div class="content">
        <div class="content-area">
          <div class="tile-wrapper">
            <div class="tile-container">
              <div class="tile whole">
                <h1>Analytics</h1>
              </div>
              <?php if ( isset($_SESSION['viewing_user_id']) && ( !isFinanceCommittee() || ( isFinanceCommittee() && $_SESSION['viewing_user_id'] != $_SESSION['user']['id'] ) ) ) {
                      require("include/analytics/individual.php");
                    }
                    else {
                      if ( isset($_SESSION['user']) ) {
              ?>
                        <div class="tile whole">
                          <h1>Cannot View Organization Analytics</h1>
                          <hr>
                          <p>Please select an org to get its organizational analytics.</p>
                        </div>
              <?php
                      }
                      else {
              ?>
                        <div class="tile whole">
                          <h1>Cannot View Organization Analytics</h1>
                          <hr>
                          <h1>Please login to get organization-specific analytics.</h1>
                        </div>
              <?php
                      }
                    }
                    require("include/analytics/all.php");
              ?>
              <div class="tile third">
                <h1>First</h1>
              </div>
              <div class="tile third">
                <h1>Second</h1>
              </div>
              <div class="tile third">
                <h1>Third</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- JavaScript at the end of the page so it loads faster. -->

    <?php require("include/which-js.php"); ?>

<!-- End JavaScript -->

  </body>

</html>
