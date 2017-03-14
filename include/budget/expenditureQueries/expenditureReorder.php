<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/preserveViewing.php"); ?>
<?php if ( !isLoggedIn() ) { $_SESSION['feedback'] = ['color' => 'red', 'message' =>'Please login to view that page.']; header("Location: /index.php"); die; } ?>

<?php

  $i = 1;
  $datArray = array();
  parse_str($_POST['expend'], $datArray);
  $arrayLen = count($datArray['expend']);
  $secondPart = "";
  $sqlStatement = "UPDATE expenditure SET expend_order = CASE expend_id ";
  foreach ( $datArray['expend'] as $value ) {
    $sqlStatement .= "WHEN $value THEN $i ";
    if ( $i < $arrayLen ) { $secondPart .= "$value, "; } else { $secondPart .= "$value"; }
    $i++;
  }
  $sqlStatement .= "END WHERE expend_id IN (";
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
