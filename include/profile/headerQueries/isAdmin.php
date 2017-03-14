<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $headerQuery = $mysqli->prepare("SELECT total.year_name, users.screenname AS org_name, total.year_id, users.id AS org_id FROM users JOIN (SELECT year.year_name, year.year_id, org_year.org_id FROM year JOIN org_year ON year.year_id = org_year.year_id) AS total ON total.org_id = users.id ORDER BY total.year_id DESC, org_name ASC") ) {
    /* bind parameters for markers */

    if ($headerQuery->execute()){
      $result = $headerQuery->get_result();
      $array = array();
      while ($row = $result->fetch_assoc()) {
        $array[] = $row;
      }
    } else{
      error_log ("Didn't work");
    }

    $headerQuery->close();
  }
  /* close connection */
  $mysqli->close();

  $result = array();
  foreach ($array as $data) {
    $id = $data['year_name'];
    if (isset($result[$id])) {
       $result[$id][] = $data;
    } else {
       $result[$id] = array($data);
    }
  }

  echo '<ul class="title-dropdown-option">';
  foreach ($result as $key => $year) {
    echo "<li><a href='?viewing_year={$year[0]['year_id']}'>$key</a><li>";
  }
  echo '</ul>';

?>
