<?php session_start(); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>

<?php
  $field = $_POST['field'];
  $number = $_POST['number'];
  $value = $_POST['value'];

  // DO EVENT STUFF
  if ( substr($field, 0, 5) == "event" ) {
    switch ($field) {
      case "event_attendance":
        $field = "expected_attendance";
        break;
      case "event_details":
        $field = "details";
        break;
      default:
        break;
    }
  }
  elseif ( substr($field, 0, 5) == "expen" ) {
    switch ($field) {
      case "expend_quantity":
        $field = "quantity";
        break;
      case "expend_price":
        $field = "price";
        break;
      case "expend_price_quote_first":
        $field = "first_source";
        break;
      case "expend_price_quote_second":
        $field = "second_source";
        break;
      case "expend_allocation":
        $field = "allocated";
        break;
      case "expend_reason":
        $field = "reason";
        break;
      default:
        break;
    }
  }

  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  if ( $field == "event_name" ) {
    // EVENT NAME
    if ( $query = $mysqli->prepare("UPDATE event SET event_name = ? WHERE event_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "event_type" ) {
    if ( $query = $mysqli->prepare("UPDATE event SET event_type = ? WHERE event_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "event_date" ) {
    $value = str_replace("&#x2F;", "/", $value);
    $oldFormat = DateTime::createFromFormat('m/d/Y', $value);
    $newFormat = $oldFormat->format('Y-m-d');
    if ( $query = $mysqli->prepare("UPDATE event SET event_date = ? WHERE event_id = ?") ) {
      $query->bind_param("si", $newFormat, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "event_location" ) {
    if ( $query = $mysqli->prepare("UPDATE event SET event_location = ? WHERE event_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "expected_attendance" ) {
    if ( $query = $mysqli->prepare("UPDATE event SET expected_attendance = ? WHERE event_id = ?") ) {
      $query->bind_param("ii", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "details" ) {
    if ( $query = $mysqli->prepare("UPDATE event SET details = ? WHERE event_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "expend_name" ) {
    if ( $query = $mysqli->prepare("UPDATE expenditure SET expend_name = ? WHERE expend_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "quantity" ) {
    if ( $query = $mysqli->prepare("UPDATE expenditure SET quantity = ? WHERE expend_id = ?") ) {
      $query->bind_param("ii", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "price" ) {
    if (substr($value, 0, 1) === '$') {
      $value = substr($value, 1);
    }
    if ( $query = $mysqli->prepare("UPDATE expenditure SET price = ? WHERE expend_id = ?") ) {
      $query->bind_param("di", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "first_source" ) {
    if ( $query = $mysqli->prepare("UPDATE expenditure SET first_source = ? WHERE expend_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "second_source" ) {
    if ( $query = $mysqli->prepare("UPDATE expenditure SET second_source = ? WHERE expend_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "allocated" ) {
    if (substr($value, 0, 1) === '$') {
      $value = substr($value, 1);
    }
    if ( $query = $mysqli->prepare("UPDATE expenditure SET allocated = ? WHERE expend_id = ?") ) {
      $query->bind_param("di", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }
  elseif ( $field == "reason" ) {
    if ( $query = $mysqli->prepare("UPDATE expenditure SET reason = ? WHERE expend_id = ?") ) {
      $query->bind_param("si", $value, $number);
      if (!$query->execute()){
        error_log ("Didn't work");
      }
      $query->close();
    }
  }

  /* close connection */
  $mysqli->close();
?>
