<h1>All Organizations Requested vs Allocated Over Time</h1>
<hr>
<div id="canvas-holder" style="padding: 3em;">
    <canvas id="requested-vs-allocated-line" />
</div>

<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( isFinanceCommittee() ) {
    if ( $overTimeQuery = $mysqli->prepare("SELECT SUM(expenditure.allocated) AS allocated, SUM(expenditure.price * expenditure.quantity) AS requested, org_year_event.year_name FROM (SELECT org_year.year_name, event.event_id FROM (SELECT year.year_name, org_year.org_year_id FROM year JOIN org_year ON year.year_id = org_year.year_id) AS org_year JOIN event ON event.org_year_id = org_year.org_year_id WHERE event.visible = 1) AS org_year_event JOIN expenditure ON expenditure.event_id = org_year_event.event_id WHERE expenditure.visible = 1 GROUP BY org_year_event.year_name") ) {
      /* bind parameters for markers */
      if ($overTimeQuery->execute()){
        $overTimeResult = $overTimeQuery->get_result();
        $overTimeArray = array();
        while ($row = $overTimeResult->fetch_assoc()) {
          $overTimeArray[] = $row;
        }
      } else{
        error_log ("Didn't work");
      }
      $overTimeQuery->close();
    }
  }
  else {
    if ( $overTimeQuery = $mysqli->prepare("SELECT SUM(expenditure.allocated) AS allocated, SUM(expenditure.price * expenditure.quantity) AS requested, org_year_event.year_name FROM (SELECT org_year.year_name, event.event_id FROM (SELECT year.year_name, org_year.org_year_id FROM year JOIN org_year ON year.year_id = org_year.year_id WHERE year.done_allocating = 1) AS org_year JOIN event ON event.org_year_id = org_year.org_year_id WHERE event.visible = 1) AS org_year_event JOIN expenditure ON expenditure.event_id = org_year_event.event_id WHERE expenditure.visible = 1 GROUP BY org_year_event.year_name") ) {
      /* bind parameters for markers */
      if ($overTimeQuery->execute()){
        $overTimeResult = $overTimeQuery->get_result();
        $overTimeArray = array();
        while ($row = $overTimeResult->fetch_assoc()) {
          $overTimeArray[] = $row;
        }
      } else{
        error_log ("Didn't work");
      }
      $overTimeQuery->close();
    }
  }
  /* close connection */
  $mysqli->close();
?>

<script type="text/javascript">

  var configRequestedAllocatedLine = {
      type: 'line',
      data: {
          labels: [
          <?php
            foreach($overTimeArray as $year) {
              echo '"' . $year['year_name'] . '", ';
            }
          ?>
          ],
          datasets: [{
              label: "Allocated",
              data: [
                <?php
                  foreach($overTimeArray as $year) {
                    echo $year['allocated'] . ', ';
                  }
                ?>
              ],
              fill: true,
              borderColor: "rgba(255, 0, 0, 0.9)",
              backgroundColor: "rgba(255, 0, 0, 0.5)",
          }, {
              label: "Requested",
              data: [
                <?php
                  foreach($overTimeArray as $year) {
                    echo $year['requested'] . ', ';
                  }
                ?>
              ],
              borderColor: "#999999",
              backgroundColor: "rgba(128, 128, 128, 0.9)",
              fill: true,
          }]
      },
      options: {
          responsive: true,
          legend: {
              position: 'right',
          },
          hover: {
              mode: 'label'
          },
          scales: {
              xAxes: [{
                  display: true,
                  scaleLabel: {
                      display: true,
                      labelString: 'Year'
                  }
              }],
              yAxes: [{
                  display: true,
                  scaleLabel: {
                      display: true,
                      labelString: 'Money'
                  }
              }]
          },
      }
  };
</script>
