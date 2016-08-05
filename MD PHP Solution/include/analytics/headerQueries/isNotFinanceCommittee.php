<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $headerQuery = $mysqli->prepare("SELECT total.year_name, users.screenname AS org_name, total.year_id, users.id AS org_id FROM users JOIN (SELECT year.year_name, year.year_id, org_year.org_id FROM year JOIN org_year ON year.year_id = org_year.year_id) AS total ON total.org_id = users.id WHERE users.id = ? ORDER BY total.year_id DESC") ) {
    /* bind parameters for markers */
    $headerQuery->bind_param("i", $_SESSION['user']['id']);

    if ($headerQuery->execute()){
      $result = $headerQuery->get_result();
      $array  = $result->fetch_all(MYSQLI_ASSOC);
    } else{
      error_log ("Didn't work");
    }

    $headerQuery->close();
  }
  /* close connection */
  $mysqli->close();

  echo '<ul class="title-dropdown-option">';
  foreach ($array as $year) {
    echo "<li><a href='?viewing_year={$year['year_id']}''>{$year['year_name']}</a></li>";
  }
  echo '</ul>';
?>
