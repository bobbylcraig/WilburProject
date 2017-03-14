<div class="tile desktop-12">
  <h1>All Organization Report</h1>
</div>

<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $organizationQuery = $mysqli->prepare("SELECT COUNT(*) AS orgs FROM org_year WHERE org_year.year_id = ?") ) {
    /* bind parameters for markers */
    $organizationQuery->bind_param("i", $_SESSION['viewing_year']);

    if ($organizationQuery->execute()){
      $organizationResult = $organizationQuery->get_result();
      $organizations = array();
      while ($row = $organizationResult->fetch_assoc()) {
        $organizations[] = $row;
      }
      $organizations = $organizations[0]['orgs'];
    } else{
      error_log ("Didn't work");
    }
    $organizationQuery->close();
  }
  if ( $eventQuery = $mysqli->prepare("SELECT COUNT(*) AS events FROM event JOIN org_year ON org_year.org_year_id = event.org_year_id WHERE org_year.year_id = ? and event.visible = 1") ) {
    /* bind parameters for markers */
    $eventQuery->bind_param("i", $_SESSION['viewing_year']);

    if ($eventQuery->execute()){
      $eventResult = $eventQuery->get_result();
      $events = array();
      while ($row = $eventResult->fetch_assoc()) {
        $events[] = $row;
      }
      $events = $events[0]['events'];
    } else{
      error_log ("Didn't work");
    }
    $eventQuery->close();
  }
  if ( $expendQuery = $mysqli->prepare("SELECT COUNT(*) AS expenditures FROM expenditure JOIN (SELECT event_id FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE event.visible = 1 and org_year.year_id = ?) AS year_org ON expenditure.event_id = year_org.event_id WHERE expenditure.visible = 1") ) {
    /* bind parameters for markers */
    $expendQuery->bind_param("i", $_SESSION['viewing_year']);

    if ($expendQuery->execute()){
      $expendResult = $expendQuery->get_result();
      $expenditures = array();
      while ($row = $expendResult->fetch_assoc()) {
        $expenditures[] = $row;
      }
      $expenditures = $expenditures[0]['expenditures'];
    } else{
      error_log ("Didn't work");
    }
    $expendQuery->close();
  }
  /* close connection */
  $mysqli->close();
?>

<div class="tile all-4" style="text-align: center; color: #f33535;">
  <p>
    <span class="count-js" count-to="<?php echo $organizations; ?>" style="font-size: 5em;">0</span>
    <span style="font-size: 1em;">Organizations</span>
  </p>
</div>
<div class="tile all-4" style="text-align: center;">
  <p>
    <span class="count-js" count-to="<?php echo $events; ?>" style="font-size: 5em;">0</span>
    <span style="font-size: 1em;">Events</span>
  </p>
</div>
<div class="tile all-4" style="text-align: center; color: navy;">
  <p>
    <span class="count-js" count-to="<?php echo $expenditures; ?>" style="font-size: 5em;">0</span>
    <span style="font-size: 1em;">Line Items</span>
  </p>
</div>

<div class="tile desktop-6">
  <?php require("charts/all-charts/by-category-requested.php"); ?>
</div>
<div class="tile desktop-6">
  <?php require("charts/all-charts/by-category-allocated.php"); ?>
</div>
<div class="tile desktop-12">
  <?php require("charts/all-charts/line-chart-request-allocated.php"); ?>
</div>

<script type="text/javascript">
  window.onload = function() {
    var byCategoryRequest = document.getElementById("by-category-request").getContext("2d");
    window.myDoughnut = new Chart(byCategoryRequest, configByCategoryRequest);
    var byCategoryAllocated = document.getElementById("by-category-allocated").getContext("2d");
    window.myDoughnut = new Chart(byCategoryAllocated, configByCategoryAllocated);
    var requestedAllocatedLine = document.getElementById("requested-vs-allocated-line").getContext("2d");
    requestedAllocatedLine.canvas.height = 80;
    window.myLine = new Chart(requestedAllocatedLine, configRequestedAllocatedLine);
  };
</script>
