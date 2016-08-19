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

      <?php require("include/budget/header.php"); ?>

      <div class="partial-modal">

        <?php require("include/budget/sidebar.php"); ?>

        <?php require("include/budget/sub-header.php"); ?>

        <div class="main">

          <div class="content" style="<?php if ( isFinanceCommittee() ) { echo 'padding-top: 8em'; } else { echo 'padding-top: 4em'; } ?>">

            <div class="event-section">
              <div class="event-card">
                <div class="card-content" style="text-align: center;">
                  <h2 style="font-weight: 400;">
                    <?php if ( isFinanceCommittee() && $_SESSION['user']['id'] == $_SESSION['viewing_user_id'] ) { ?>
                      Please select an organization to get started.
                    <?php } elseif ( empty($sidebarArray) ) { ?>
                      Please add an event to get started.
                    <?php } else { ?>
                      Please select an event to get started.
                    <?php } ?>
                  </h2>
                </div>
              </div>
            </div>

          </div> <!-- End content -->

        </div> <!-- End main -->

      </div>

    </div>

    <div class="option-nav">
      <?php if ( canEdit() ) { ?>
        <nav class="container">
          <?php if ( isset($_POST['viewing_event']) ) { ?>
            <a id="add-expenditure-button" tooltip="Add Expenditure" class="buttons"><i class="material-icons">add_circle_outline</i></a>
            <a id="delete-event-button" tooltip="Delete Event" class="buttons"><i class="material-icons">delete</i></a>
            <?php if ( ($_SESSION['user']['role'] == 'org') || (( $_SESSION['viewing_user_id'] != $_SESSION['user']['id'] ) && canEdit()) ) { ?>
              <a href="/include/budget/eventQueries/addEvent.php?adding_user_id=<?php echo $_SESSION['viewing_user_id']; ?>" tooltip="Add Event" class="buttons"><i class="material-icons">add</i></a>
            <?php } ?>
            <?php if ( isAdmin() ) { ?>
              <a href="#" tooltip="Visited Event" class="buttons"><i class="material-icons">visibility_off</i></a>
            <?php } ?>
          <?php } else if ( !(isFinanceCommittee() && $_SESSION['user']['id'] == $_SESSION['viewing_user_id']) ) { ?>
              <a href="/include/budget/eventQueries/addEvent.php?adding_user_id=<?php echo $_SESSION['viewing_user_id']; ?>" tooltip="Add Event" class="buttons"><i class="material-icons">add</i></a>
          <?php } ?>
          <a style="cursor: default;" tooltip="Options" class="buttons main-button"><i class="rotate material-icons">settings</i></a>
        </nav>
      <?php } ?>
    </div>

<!-- JavaScript at the end of the page so it loads faster. -->

    <?php require("include/which-js.php"); ?>

<!-- End JavaScript -->

  </body>

</html>
