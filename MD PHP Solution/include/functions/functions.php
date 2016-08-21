<?php
  /*
   * isLoggedIn Function
   * Checks if user is logged in
   */
  function isLoggedIn() {
    if (isset($_SESSION['user']['role']))
      return true;
    else
      return false;
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
   * isDoneAllocating function
   * For pulling the done_allocating attribute of year
   */
   function isDoneAllocating() {
     $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
     if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
     }
     if ( $yearQuery = $mysqli->prepare("SELECT done_allocating FROM year WHERE year_id = ?") ) {
       /* bind parameters for markers */
       $yearQuery->bind_param("i", $_SESSION['viewing_year']);

       if ($yearQuery->execute()){
         $yearResult = $yearQuery->get_result();
         $done_allocating = array();
         while ($row = $yearResult->fetch_assoc()) {
           $done_allocating[] = $row;
         }
         $done_allocating = $done_allocating[0]['done_allocating'];
       } else{
         error_log ("Didn't work");
       }
       $yearQuery->close();
     }
     $mysqli->close();
     return $done_allocating || isFinanceCommittee();
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
    if ($diff > 1440 || !isset($t0)) {
      return true;
    }
    else {
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
      case 'Office Supplies&#x2F;Printing&#x2F;Ads':
          return "print";
          break;
      case 'Capital Purchase':
          return "attach_money";
          break;
      default:
          return 'help';
    }
  }
   /*
    * isVisited function
    * For pulling the visited status from the event
    */
    function isVisitedIcon() {
      $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
      if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }
      if ( $visitedQuery = $mysqli->prepare("SELECT visited FROM event WHERE event_id = ?") ) {
        /* bind parameters for markers */
        $visitedQuery->bind_param("i", $_POST['event_id']);

        if ($visitedQuery->execute()){
          $visitedResult = $visitedQuery->get_result();
          $visited = array();
          while ($row = $visitedResult->fetch_assoc()) {
            $visited[] = $row;
          }
          $visited  = $visited[0]['visited'];
        } else{
          error_log ("Didn't work");
        }
        $visitedQuery->close();
      }
      $mysqli->close();
      if ( $visited ) {
        $tooltip = "Visited Event";
        $id = "viewed-event";
        $icon = "visibility";
      }
      else {
        $tooltip = "Unvisited Event";
        $id = "unviewed-event";
        $icon = "visibility_off";
      }
      return "<a tooltip='$tooltip' id='$id' class='buttons event-visibility'><i class='material-icons'>$icon</i></a>";
    }
    /*
     * grabRecentYear function
     * For pulling the most recently finished budgeting year
     */
     function grabRecentYear() {
       $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
       if (mysqli_connect_errno()) {
         printf("Connect failed: %s\n", mysqli_connect_error());
         exit();
       }
       if ( $recentQuery = $mysqli->prepare("SELECT year_id FROM year WHERE done_allocating = 1 ORDER BY year_id DESC")) {
         if ($recentQuery->execute()){
           $recentResult = $recentQuery->get_result();
           $recentArray  = $recentResult->fetch_array(MYSQLI_ASSOC); // this does work :)
         } else{
           error_log ("Didn't work");
         }
         $recentQuery->close();
       }
       /* close connection */
       $mysqli->close();
       return $recentArray['year_id'];
     }
     /*
      * isNull function
      */
      function isNull($data) {
        if ( is_null($data) ) {
          return "<span style='opacity: 0.3;''>Org Not Registered Yet</span>";
        }
        else {
          return $data;
        }
      }


/***************************************************
 ***************************************************
     NOT FUNCTIONS --- CODE TO RUN ON EVERY PAGE
 ***************************************************
 ***************************************************/

  // Logout user if logged in passed certain amount of time
  if ( isLoggedIn() && auto_logout() ) {
    session_destroy();
    session_start();
    $_SESSION['feedback'] = ['color' => 'yellow', 'message' =>'Session timed out. Please login again.'];
    header("Location: /redirect.html");
    die;
  }
?>
