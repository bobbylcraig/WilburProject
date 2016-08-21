<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $organizationQuery = $mysqli->prepare("SELECT screenname, total_events, visited_events, allocated, requested, org_id AS id, year_id, expenditure.org_year_id, president, president_email, treasurer, treasurer_email, isActive FROM (SELECT event.org_year_id, SUM(allocated) AS allocated, SUM(price*quantity) AS requested FROM expenditure JOIN (SELECT org_year_id, event_id FROM event) AS event ON expenditure.event_id = event.event_id WHERE expenditure.visible = 1 GROUP BY org_year_id) AS expenditure RIGHT JOIN (SELECT screenname, event_name, event_id, total_events, visited_events, org_id, year_id, org_year.org_year_id, president, president_email, treasurer, treasurer_email, isActive FROM (SELECT SUM(visited) AS visited_events, COUNT(*) AS total_events, event_name, org_year_id, event_id FROM event WHERE event.visible = 1 GROUP BY org_year_id) AS event RIGHT JOIN (SELECT org_year.org_id, year_id, org_year_id, president, president_email, treasurer, treasurer_email, screenname, isActive FROM users JOIN (SELECT org_year.org_id, org_year.year_id, org_year_id, president, president_email, treasurer, treasurer_email FROM org_year JOIN year ON org_year.year_id = year.year_id) AS org_year ON org_year.org_id = users.id) AS org_year ON org_year.org_year_id = event.org_year_id GROUP BY org_year_id) AS event ON expenditure.org_year_id = event.org_year_id WHERE year_id = ? GROUP BY event.org_year_id") ) {
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
  if ( $usersQuery = $mysqli->prepare("SELECT id, screenname, username, category, isActive FROM users WHERE role = 'org' ORDER BY isActive DESC") ) {
    /* bind parameters for markers */
    if ($usersQuery->execute()){
      $usersResult = $usersQuery->get_result();
      $users = array();
      while ($row = $usersResult->fetch_assoc()) {
        $users[] = $row;
      }
    } else{
      error_log ("Didn't work");
    }
    $usersQuery->close();
  }
  if ( $users2Query = $mysqli->prepare("SELECT id, screenname, username, isActive FROM users WHERE role != 'org' ORDER BY isActive DESC") ) {
    /* bind parameters for markers */
    if ($users2Query->execute()){
      $users2Result = $users2Query->get_result();
      $users2 = array();
      while ($row = $users2Result->fetch_assoc()) {
        $users2[] = $row;
      }
    } else{
      error_log ("Didn't work");
    }
    $users2Query->close();
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
          <th>Events</th>
          <th>Requested</th>
          <th>Allocated</th>
          <th>President</th>
          <th>President Email</th>
          <th>Treasurer</th>
          <th>Treasurer Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($organizations as $org) { ?>
        <tr>
          <td data-title="Organization"><?php echo isNull($org['screenname']); ?></td>
          <td data-title="Events"><?php if ( $org['total_events'] == 0 ) { echo "No Events Yet"; } else { echo round( ($org['visited_events']/$org['total_events']) * 100 ) . "% Completed"; }  ?></td>
          <td data-title="Requested"><?php if (is_null($org['requested'])) { echo "$0.00"; } else { echo money_format("%.2n", $org['requested']); } ?></td>
          <td data-title="Allocated"><?php if (is_null($org['requested'])) { echo "$0.00"; } else { echo money_format("%.2n", $org['allocated']); } ?></td>
          <td data-title="President"><?php echo isNull($org['president']); ?></td>
          <td data-title="President Email"><?php echo isNull($org['president_email']); ?></td>
          <td data-title="Treasurer"><?php echo isNull($org['treasurer']); ?></td>
          <td data-title="President Email"><?php echo isNull($org['treasurer_email']); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<div class="tile desktop-6 tablet-6">
  <div class="table-responsive-vertical">
    <table id="table" class="table">
      <thead>
        <tr>
          <th>Organization</th>
          <th>Category</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) { ?>
        <tr>
          <td data-title="Organization"><?php echo isNull($user['screenname']); ?></td>
          <td data-title="Category"><?php echo $user['category']; ?></td>
          <td data-title="Status"><?php if ( $user['isActive'] ) { echo "Active"; } else { echo "Inactive"; } ?></td>
          <td data-title="Change Org Status">
            <?php if ( $user['isActive'] ) { echo "<i tooltip-delete='Delete Org' class='material-icons delete-org' org='{$user['id']}'>delete</i>"; }
                  else { echo "<i tooltip-delete='Reinstate Org' class='material-icons check-org' org='{$user['id']}'>check</i>"; } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<div class="tile desktop-6 tablet-6">
  <div class="table-responsive-vertical">
    <table id="table" class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Username</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users2 as $user2) { ?>
        <tr>
          <td data-title="Name"><?php echo isNull($user2['screenname']); ?></td>
          <td data-title="Username"><?php echo $user2['username']; ?></td>
          <td data-title="Username"><?php if ( $user2['isActive'] ) { echo "Active"; } else { echo "Inactive"; } ?></td>
          <td data-title="Change Org Status">
            <?php if ( $user2['username'] != "bobbylcraig" ):
                    if ( $user2['isActive'] ) { echo "<i tooltip-delete='Delete Org' class='material-icons delete-org' org='{$user['id']}'>delete</i>"; }
                    else { echo "<i tooltip-delete='Reinstate Org' class='material-icons check-org' org='{$user['id']}'>check</i>"; }
                  endif;
            ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
