<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>
<?php if ( !isLoggedIn() ) { $_SESSION['feedback'] = ['color' => 'red', 'message' =>'Please login to view that page.']; header("Location: /index.php"); die; } ?>

<?php
  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $eventQuery = $mysqli->prepare("SELECT event_id, event_name, event_type, event_date, event_location, expected_attendance, details FROM event WHERE event_id = ?") ) {
    /* bind parameters for markers */
    $eventQuery->bind_param("i", $_POST['event_id']);

    if ($eventQuery->execute()){
      $eventResult = $eventQuery->get_result();
      $eventInfo = array();
      while ($row = $eventResult->fetch_assoc()) {
        $eventInfo[] = $row;
      }
      $eventInfo = $eventInfo[0];
    } else{
      error_log ("Didn't work");
    }
    $eventQuery->close();
  }
  $_POST['viewing_event'] = $eventInfo['event_id'];
  if ( $expendQuery = $mysqli->prepare("SELECT expend_id, expend_name, quantity, price, allocated, first_source, second_source, reason FROM expenditure WHERE event_id = ? and visible = 1 ORDER BY expend_order") ) {
    /* bind parameters for markers */
    $expendQuery->bind_param("i", $_POST['event_id']);

    if ( $expendQuery->execute() ) {
      $expendResult = $expendQuery->get_result();
      $expendInfo = array();
      while ($row = $expendResult->fetch_assoc()) {
        $expendInfo[] = $row;
      }
    } else{
      error_log ("Didn't work");
    }
    $expendQuery->close();
  }
  if ( $totalQuery = $mysqli->prepare("SELECT SUM(quantity * price) AS total_price, SUM(allocated) AS total_allocated FROM expenditure WHERE event_id = ? and visible = 1 ORDER BY expend_order") ) {
    /* bind parameters for markers */
    $totalQuery->bind_param("i", $_POST['event_id']);

    if ( $totalQuery->execute() ) {
      $totalResult = $totalQuery->get_result();
      $totalPrice = array();
      while ($row = $totalResult->fetch_assoc()) {
        $totalPrice[] = $row;
      }
      $totalPrice = $totalPrice[0];
    } else{
      error_log ("Didn't work");
    }
    $totalQuery->close();
  }
  /* close connection */
  $mysqli->close();
?>

<div class="event-card">
  <div class="card-top">
    <div class="card-top-column turn-column">
      <div class="turn-text">
        Requested
      </div>
    </div>
    <div class="card-top-column">
      <div id="requested-event" class="card-price">$ <?php if (is_null($totalPrice['total_price'])) { echo "0.00"; } else { echo $totalPrice['total_price']; } ?></div>
    </div>
    <?php if ( isDoneAllocating() ) { ?>
    <div class="card-top-column turn-column">
      <div class="turn-text">
        Allocated
      </div>
    </div>
    <div class="card-top-column">
      <div id="allocated-event" class="card-price">$ <?php if (is_null($totalPrice['total_allocated'])) { echo "0.00"; } else { echo $totalPrice['total_allocated']; } ?></div>
    </div>
    <?php } ?>
    <div class="card-top-column turn-column turn-title">
      <div class="turn-text">
        Event/Item
      </div>
    </div>
    <div class="card-top-column card-title">
      <?php if ( $eventInfo['event_name'] ) { echo $eventInfo['event_name']; } else { echo "Click below to edit..."; } ?>
    </div>
    <?php if ( canEdit() ) { ?>
      <nav class="container">
        <?php if ( isset($_POST['viewing_event']) ) { ?>
          <a id="add-expenditure-button" tooltip="Add Expenditure" class="buttons"><i class="material-icons">add_circle_outline</i></a>
          <a id="delete-event-button" tooltip="Delete Event" class="buttons"><i class="material-icons">delete</i></a>
          <?php if ( ($_SESSION['user']['role'] == 'org') || (( $_SESSION['viewing_user_id'] != $_SESSION['user']['id'] && isFinanceCommittee() ) ) ) { ?>
            <a href="/include/budget/eventQueries/addEvent.php?adding_user_id=<?php echo $_SESSION['viewing_user_id']; ?>" tooltip="Add Event" class="buttons"><i class="material-icons">add</i></a>
          <?php } ?>
          <?php if ( isAdmin() ) { ?>
            <?php echo isVisitedIcon(); ?>
          <?php } ?>
        <?php } else { ?>
            <a href="/include/budget/eventQueries/addEvent.php?adding_user_id=<?php echo $_SESSION['viewing_user_id']; ?>" tooltip="Add Event" class="buttons"><i class="material-icons">add</i></a>
        <?php } ?>
        <a style="cursor: default;" tooltip="Options" class="buttons main-button"><i class="rotate material-icons">settings</i></a>
      </nav>
    <?php } ?>
  </div>
  <div class="card-content">
    <p><span class="detail-heading">Event Name</span><br><span number="<?php echo $eventInfo['event_id'] ?>" id="event_name" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $eventInfo['event_name'] ) { echo $eventInfo['event_name']; } else { echo "Click to edit..."; } ?></span></p>

    <p><span class="detail-heading">Event Type</span><br><span number="<?php echo $eventInfo['event_id'] ?>" id="event_type" class="detail <?php if ( canEdit() ) { echo 'editable-select'; } ?>"><?php if ( $eventInfo['event_type'] ) { echo $eventInfo['event_type']; } else { echo "Click to edit..."; } ?></span></p>

    <p><span class="detail-heading">Event Date</span><br><span number="<?php echo $eventInfo['event_id'] ?>" id="event_date" class="detail <?php if ( canEdit() ) { echo 'editable-masked'; } ?>"><?php if ( $eventInfo['event_date'] ) { echo DateTime::createFromFormat('Y-m-d', $eventInfo['event_date'])->format('m/d/Y'); } else { echo "Click to edit..."; } ?></span></p>

    <p><span class="detail-heading">Event Location</span><br><span number="<?php echo $eventInfo['event_id'] ?>" id="event_location" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $eventInfo['event_location'] ) { echo $eventInfo['event_location']; } else { echo "Click to edit..."; } ?></span></p>

    <p><span class="detail-heading">Expected Attendance</span><br><span number="<?php echo $eventInfo['event_id'] ?>" id="event_attendance" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $eventInfo['expected_attendance'] ) { echo $eventInfo['expected_attendance']; } else { echo "Click to edit..."; } ?></span></p>
    <hr>
    <p><span class="detail-heading">Event Details</span><br><span number="<?php echo $eventInfo['event_id'] ?>" id="event_details" class="detail textarea <?php if ( canEdit() ) { echo 'editable-textarea'; } ?>"><?php if ( $eventInfo['details'] ) { echo $eventInfo['details']; } else { echo "Click to edit..."; } ?></span></p>
  </div>
</div>

<?php require("expenditure-card.php") ?>
