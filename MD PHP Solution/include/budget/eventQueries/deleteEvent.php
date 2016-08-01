<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>
<?php
  if ( canEdit() ) {
    $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    if ( $query = $mysqli->prepare("SELECT org_year.org_year_id FROM org_year JOIN users ON org_year.org_id = ? WHERE org_year.year_id = ?") ) {
      $query->bind_param("ii", $_GET['adding_user_id'], $_SESSION['current_year']);
      if ($query->execute()){
        $queryResult = $query->get_result();
        $result  = $queryResult->fetch_all(MYSQLI_ASSOC);
      } else{
        error_log ("Didn't work");
      }
      $query->close();
    }
    $mysqli->close();
  }
?>
