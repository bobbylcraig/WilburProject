<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>

<?php
  $event_id = $_POST['event_id'];
  if ( canEdit() ) {
    $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    if ( $query = $mysqli->prepare("SELECT expend_order FROM expenditure WHERE event_id = ? ORDER BY expend_order DESC") ) {
      /* bind parameters for markers */
      $query->bind_param("i", $_POST['event_id']);

      if ($query->execute()){
        $result = $query->get_result();
        $info = array();
        while ($row = $result->fetch_assoc()) {
          $info[] = $row;
        }
      } else{
        error_log ("Didn't work");
      }
      $query->close();
    }
    if (!empty($info)) {
      $next = $info[0]['expend_order'] + 1;
    }
    else {
      $next = 1;
    }
    if ( $query = $mysqli->prepare("INSERT INTO `expenditure` (expend_name,event_id,expend_order) VALUES ('New Line Item', ?, ?)") ) {
      $query->bind_param("ii", $event_id, $next);
      if ( !$query->execute() ){
        error_log ("Didn't work");
      }
      $query->close();
    }
    $mysqli->close();
  }
?>
