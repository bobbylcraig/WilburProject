<h1>Requested By Organization Category</h1>
<hr>
<div id="canvas-holder">
    <canvas id="by-category-request" />
</div>

<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $userCatQuery = $mysqli->prepare("SELECT SUM(expenditure.quantity * expenditure.price) AS requested, SUM(expenditure.allocated) AS allocated, mom.category FROM (SELECT dad.category, event.event_id, dad.year_id FROM (SELECT users.category, org_year.org_year_id, org_year.year_id FROM users JOIN org_year ON users.id = org_year.org_id WHERE org_year.year_id = ?) AS dad JOIN event ON event.org_year_id = dad.org_year_id WHERE event.visible = 1) AS mom JOIN expenditure ON mom.event_id = expenditure.event_id WHERE expenditure.visible = 1 GROUP BY mom.category") ) {
    /* bind parameters for markers */
    $userCatQuery->bind_param("i", $_SESSION['viewing_year']);

    if ($userCatQuery->execute()){
      $userCatResult = $userCatQuery->get_result();
      $userCatArray = array();
      while ($row = $userCatResult->fetch_assoc()) {
        $userCatArray[] = $row;
      }
    } else{
      error_log ("Didn't work");
    }

    $userCatQuery->close();
  }
  /* close connection */
  $mysqli->close();
?>

<script>
var configByCategoryRequest = {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [
              <?php
                    foreach ($userCatArray as $userCat) {
                      if ($userCat['requested'] != 0) {
                        echo $userCat['requested'] . ", ";
                      }
                    };
              ?>
            ],
            backgroundColor: [
              <?php
                    foreach ($userCatArray as $userCat) {
                      if ($userCat['requested'] != 0) {
                        echo "randomColor(), ";
                      }
                    };
              ?>
            ],
            label: "Requested"
        }],
        labels: [
          <?php
            foreach ($userCatArray as $userCat) {
              if ($userCat['requested'] != 0) {
                echo '"' . $userCat['category'] . '"' . ", ";
              }
            };
          ?>
        ]
    },
    options: {
        responsive: true,
        legend: {
            position: 'right',
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
};
</script>
