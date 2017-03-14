<?php
// Sets variables based on query string
if ( !isFinanceCommittee() ) {
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $loginQuery = $mysqli->prepare("SELECT year_id FROM org_year WHERE org_id = ? ORDER BY year_id DESC")) {
    /* bind parameters for markers */
    $loginQuery->bind_param("i", $_SESSION['user']['id'] );

    if ($loginQuery->execute()){
      $result = $loginQuery->get_result();
      $array  = $result->fetch_array(MYSQLI_ASSOC); // this does work :)
    } else{
      error_log ("Didn't work");
    }
    $loginQuery->close();
  }
  /* close connection */
  $mysqli->close();
  $_SESSION['current_year'] = $array['year_id'];
}
else {
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $loginQuery = $mysqli->prepare("SELECT year_id FROM year ORDER BY year_id DESC")) {
    /* bind parameters for markers */
    if ($loginQuery->execute()){
      $result = $loginQuery->get_result();
      $array  = $result->fetch_array(MYSQLI_ASSOC); // this does work :)
    } else{
      error_log ("Didn't work");
    }
    $loginQuery->close();
  }
  /* close connection */
  $mysqli->close();
  $_SESSION['current_year'] = $array['year_id'];
}

if ( isset($_GET['viewing_year']) ) {
  $_SESSION['viewing_year'] = $_GET['viewing_year'];
}
else {
  $_SESSION['viewing_year'] = $_SESSION['current_year'];
}

if ( isset( $_GET['viewing_user_id'] ) ) {
  $_SESSION['viewing_user_id'] = $_GET['viewing_user_id'];
}
else {
  $_SESSION['viewing_user_id'] = $_SESSION['user']['id'];
}

if ( !isFinanceCommittee() ) {
  $_SESSION['viewing_user_id'] = $_SESSION['user']['id'];
}
 ?>
