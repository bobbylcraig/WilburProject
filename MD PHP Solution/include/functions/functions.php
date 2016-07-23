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
    if ($diff > 6000 || !isset($t0))
    {
      return true;
    }
    else
    {
      $_SESSION["user_time"] = time();
    }
  }
?>
