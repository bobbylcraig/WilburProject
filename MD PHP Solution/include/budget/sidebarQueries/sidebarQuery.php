<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $sidebarQuery = $mysqli->prepare("SELECT event_id, event_name, event_type, visited FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE org_year.year_id = ? and visible = 1 and org_year.org_id = ? ORDER BY event_order") ) {
    /* bind parameters for markers */
    $sidebarQuery->bind_param("ii", $_SESSION['viewing_year'], $_SESSION['viewing_user_id']);

    if ($sidebarQuery->execute()){
      $result = $sidebarQuery->get_result();
      $sidebarArray = array();
      while ($row = $result->fetch_assoc()) {
        $sidebarArray[] = $row;
      }
    } else{
      error_log ("Didn't work");
    }
    $sidebarQuery->close();
  }
  /* close connection */
  $mysqli->close();

  if ( empty($sidebarArray) ) {
    echo '<div class="peak-card empty" style="text-align: center; box-shadow: none;">No Events</div>';
  }
?>

<?php foreach ($sidebarArray as $event) { ?>
  <li class="peak-card<?php if ($event['visited'] && isFinanceCommittee()) { echo ' red'; }  ?>" id='event_<?php echo $event['event_id']; ?>'>
    <i class="material-icons event-icon"><?php echo chooseIcon($event['event_type']); ?></i>
    <div class="event-name"><?php echo $event['event_name']; ?></div>
  </li>
<?php } ?>
