<?php
  /*
   * isLoggedIn Function
   * Checks if user is logged in
   */
  function isLoggedIn() {
    if (isset($_SESSION['user']))
      return true;
    else
      return false;
  }
  /*
  * isAdmin Function
  * Checks if user is an admin
  */
  function isAdmin() {
    if ( isset( $_SESSION['user']['role'] ) ) {
      if ( $_SESSION['user']['role'] == "admin" ) {
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  /*
  * isFinanceCommittee Function
  * Checks if user is a member of the finance committee
  */
  function isFinanceCommittee() {
    if ( isset( $_SESSION['user']['role'] ) ) {
      if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  /*
  * canEdit Function
  * Checks if user is allowed to edit organization's budgets (for orgs, this is their own since they can't view others)
  */
  function canEdit() {
    if ( isset( $_SESSION['user']['role'] ) ) {
      if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "org" ) {
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  /*
   * auto_logout function
   * Logs user out after specified time period
   */
  function auto_logout() {
    if ( !isset($_SESSION["user_time"]) ) {
      $_SESSION["user_time"] = time();
      return false;
    }
    $t = time();
    $t0 = $_SESSION["user_time"];
    $diff = $t - $t0;
    if ($diff > 1140 || !isset($t0))
    {
      return true;
    }
    else
    {
      $_SESSION["user_time"] = time();
    }
  }
  /*
   * grabCurrentScreenname function
   * Runs query to grab the current viewing screenname
   */
  function grabCurrentScreenname() {
    $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    if ( $loginQuery = $mysqli->prepare("SELECT screenname FROM users WHERE id = ?")) {
      /* bind parameters for markers */
      $loginQuery->bind_param("i", $_SESSION['viewing_user_id']);

      if ($loginQuery->execute()){
        $result = $loginQuery->get_result();
        $array  = $result->fetch_array(MYSQLI_ASSOC); // this does work :)
      } else{
        error_log ("Didn't work");
      }

      $loginQuery->close();
    }
    /* close connection */
    $mysqli->close();
    return $array['screenname'];
  }
  /*
   * grabCurrentYear function
   * Runs query to grab most recent budgeting year
   */
  function grabCurrentYear() {
    $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    if ( $loginQuery = $mysqli->prepare("SELECT year_name FROM year WHERE year_id = ?")) {
      /* bind parameters for markers */
      $loginQuery->bind_param("s", $_SESSION['viewing_year']);

      if ($loginQuery->execute()){
        $result = $loginQuery->get_result();
        $array  = $result->fetch_array(MYSQLI_ASSOC); // this does work :)
      } else{
        error_log ("Didn't work");
      }

      $loginQuery->close();
    }
    /* close connection */
    $mysqli->close();
    return $array['year_name'];
  }
  /*
   * chooseIcon function
   * For choosing the icon to place beside events depending on category
   */
  function chooseIcon( $icon ) {
    switch ( $icon ) {
      case 'Conference':
          return "people";
          break;
      case 'Event':
          return "event";
          break;
      case 'Performance':
          return "music_note";
          break;
      case 'Travel':
          return "flight_takeoff";
          break;
      case 'Athletic':
          return "fitness_center";
          break;
      case 'Food':
          return "kitchen";
          break;
      case 'Office Supplies/Printing/Ads':
          return "print";
          break;
      case 'Capital Purchase':
          return "attach_money";
          break;
      default:
          return 'help';
    }
  }


/***************************************************
 ***************************************************
     NOT FUNCTIONS --- CODE TO RUN ON EVERY PAGE
 ***************************************************
 ***************************************************/

  // Logout user if logged in passed certain amount of time
  if ( auto_logout() ) {
    session_destroy();
    session_start();
    $_SESSION['feedback'] = ['color' => 'yellow', 'message' =>'Session timed out. Please login again.'];
    header("Location: /index.php");
    die;
  }
?>
