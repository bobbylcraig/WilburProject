<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>

<?php
  $expend_id = $_POST['expend_id'];
  if ( canEdit() ) {
    $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    if ( $query = $mysqli->prepare("UPDATE expenditure SET visible = 0 WHERE expend_id = ?") ) {
      $query->bind_param("i", $expend_id);
      if ( !$query->execute() ){
        error_log ("Didn't work");
      }
      $query->close();
    }
    $mysqli->close();
  }
?>
