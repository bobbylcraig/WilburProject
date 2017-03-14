<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/preserveViewing.php"); ?>
<?php if ( !isLoggedIn() ) { $_SESSION['feedback'] = ['color' => 'red', 'message' =>'Please login to view that page.']; header("Location: /index.php"); die; } ?>

<?php

  $i = 1;
  $datArray = array();
  parse_str($_POST['event'], $datArray);
  $arrayLen = count($datArray['event']);
  $secondPart = "";
  $sqlStatement = "UPDATE event SET event_order = CASE event_id ";
  foreach ( $datArray['event'] as $value ) {
    $sqlStatement .= "WHEN $value THEN $i ";
    if ( $i < $arrayLen ) { $secondPart .= "$value, "; } else { $secondPart .= "$value"; }
    $i++;
  }
  $sqlStatement .= "END WHERE event_id IN (";
  $sqlStatement .= $secondPart . ");";

  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  $mysqli->query($sqlStatement);
  // close connection
  $mysqli->close();

?>
