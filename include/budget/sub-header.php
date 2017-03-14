<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $subheadQuery = $mysqli->prepare("SELECT SUM(expenditure.price*expenditure.quantity) AS requested, SUM(expenditure.allocated) AS allocated, event.funds, (event.funds - SUM(expenditure.allocated)) AS balance FROM (SELECT event.event_id, event.visible, (SELECT total_to_allocate FROM year WHERE year_id = ?) AS funds FROM org_year JOIN event ON org_year.org_year_id = event.org_year_id WHERE org_year.year_id = ?) AS event JOIN expenditure ON expenditure.event_id = event.event_id WHERE expenditure.visible = 1 and event.visible = 1;") ) {
    /* bind parameters for markers */
    $subheadQuery->bind_param("ii", $_SESSION['viewing_year'], $_SESSION['viewing_year']);

    if ($subheadQuery->execute()){
      $subheadResult = $subheadQuery->get_result();
      $subheadArray = array();
      while ($row = $subheadResult->fetch_assoc()) {
        $subheadArray[] = $row;
      }
      $subheadArray = $subheadArray[0];
    } else{
      error_log ("Didn't work");
    }
    $subheadQuery->close();
  }
  /* close connection */
  $mysqli->close();
?>

<?php if ( isFinanceCommittee() ): ?>
<div class="sub-header">
  <div class="column turn-column">
    <div class="turn-text">
      FUNDS
    </div>
  </div>
  <div class="column">
    $<span id="funds-subheader"><?php echo money_format("%i", $subheadArray['funds']); ?></span>
  </div>
  <div class="column turn-column">
    <div class="turn-text">
      REQUESTED
    </div>
  </div>
  <div class="column">
    $<span id="requested-subheader"><?php echo money_format("%i", $subheadArray['requested']); ?></span>
  </div>
  <div class="column turn-column">
    <div class="turn-text">
      ALLOCATED
    </div>
  </div>
  <div class="column">
    $<span id="allocated-subheader"><?php echo money_format("%i", $subheadArray['allocated']); ?></span>
  </div>
  <div class="column turn-column">
    <div class="turn-text">
      BALANCE
    </div>
  </div>
  <div class="column">
    $<span id="balance-subheader"><?php echo money_format("%i", $subheadArray['balance']); ?></span>
  </div>
</div>
<?php endif; ?>
