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
        $result = array();
        while ($row = $queryResult->fetch_assoc()) {
          $result[] = $row;
        }
      } else{
        error_log ("Didn't work");
      }
      $query->close();
    }
    if ( empty($result) ) {
      //header('Location: /budget.php');
      print_r($result);
    }
    else {
      $org_year_id = $result[0]['org_year_id'];
      if ( $query = $mysqli->prepare("SELECT event_order FROM event WHERE org_year_id = ? ORDER BY event_order DESC") ) {
        $query->bind_param("i", $org_year_id);
        if ($query->execute()){
          $queryResult = $query->get_result();
          $result = array();
          while ($row = $queryResult->fetch_assoc()) {
            $result[] = $row;
          }
        } else{
          error_log ("Didn't work");
        }
        $query->close();
      }
      if (!empty($result)) {
          $next = $result[0]['event_order'] + 1;
      }
      else {
          $next = 1;
      }
      if ( $query = $mysqli->prepare("INSERT INTO `event` (event_name,org_year_id,event_order) VALUES ('New Event', ?, ?)") ) {
        $query->bind_param("ii", $org_year_id, $next);
        if (!$query->execute()){
          error_log ("Didn't work");
        }
        $query->close();
      }
    }
    $mysqli->close();
    header("Location: /budget.php?viewing_user_id={$_GET['adding_user_id']}&viewing_year={$_SESSION['current_year']}");
  }
?>
