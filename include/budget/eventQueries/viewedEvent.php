<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>
<?php
  if ( isAdmin() ) {
    $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    if ( $query = $mysqli->prepare("UPDATE event SET visited = ? WHERE event_id = ?") ) {
      $query->bind_param("ii", $_POST['new_viewed'], $_POST['event_id']);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
    $mysqli->close();
  }
?>
