<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $organizationQuery = $mysqli->prepare("SELECT id, screenname, isActive, category, requested, allocated, president, president_email, treasurer, treasurer_email, event_count, visited_count FROM users LEFT JOIN (SELECT org_year.org_id, event.requested, event.allocated, event.event_count, event.visited_count, org_year.president, org_year.president_email, org_year.treasurer, org_year.treasurer_email FROM org_year LEFT JOIN (SELECT event.org_year_id, SUM(price*quantity) AS requested, SUM(allocated) AS allocated, event.event_count, event.visited_count FROM (SELECT *, COUNT(*) AS event_count, SUM(event.visited) AS visited_count FROM event WHERE event.visible = 1 GROUP BY org_year_id) AS event JOIN expenditure ON event.event_id = expenditure.event_id WHERE event.visible = 1 and expenditure.visible = 1 GROUP BY event.org_year_id) AS event ON org_year.org_year_id = event.org_year_id WHERE org_year.year_id = ?) AS org_year ON org_year.org_id = users.id WHERE users.role = 'org'") ) {
    /* bind parameters for markers */
    $organizationQuery->bind_param("i", $_SESSION['viewing_year']);

    if ($organizationQuery->execute()){
      $organizationResult = $organizationQuery->get_result();
      $organizations = array();
      while ($row = $organizationResult->fetch_assoc()) {
        $organizations[] = $row;
      }
    } else{
      error_log ("Didn't work");
    }
    $organizationQuery->close();
  }
  $mysqli->close();
  setlocale(LC_MONETARY, 'en_US');
?>

<div class="tile desktop-12 tablet-12">
  <div class="table-responsive-vertical">
    <table id="table" class="table">
      <thead>
        <tr>
          <th>Organization</th>
          <th>Requested</th>
          <th>Allocated</th>
          <th>President</th>
          <th>President Email</th>
          <th>Treasurer</th>
          <th>Treasurer Email</th>
          <th>Org Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($organizations as $org) { ?>
        <tr>
          <td data-title="Organization"><?php echo isNull($org['screenname']); ?></td>
          <td data-title="Requested"><?php if (is_null($org['requested'])) { echo "$0.00"; } else { echo money_format("%.2n", $org['requested']); } ?></td>
          <td data-title="Allocated"><?php if (is_null($org['requested'])) { echo "$0.00"; } else { echo money_format("%.2n", $org['allocated']); } ?></td>
          <td data-title="President"><?php echo isNull($org['president']); ?></td>
          <td data-title="President Email"><?php echo isNull($org['president_email']); ?></td>
          <td data-title="Treasurer"><?php echo isNull($org['treasurer']); ?></td>
          <td data-title="President Email"><?php echo isNull($org['treasurer_email']); ?></td>
          <td data-title="Status"><?php if ( $org['isActive'] ) { echo "Active"; } else { echo "Inactive"; } ?></td>
          <td data-title="Change Org Status">
            <?php if ( $org['isActive'] ) { echo "<i title='Delete Org' class='material-icons delete-org' org='{$org['id']}'>delete</i>"; }
                  else { echo "<i title='Reinstate Org' class='material-icons check-org' org='{$org['id']}'>check</i>"; } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
