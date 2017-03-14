<?php
  require_once("config.php");
  require_once("functions.php");

  session_start();

  $username = addslashes($_POST['username']);
  $password = addslashes($_POST['password']);

  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  if ( $loginQuery = $mysqli->prepare("SELECT * FROM users WHERE username = ?")) {
    /* bind parameters for markers */
    $loginQuery->bind_param("s", $username);

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

  if (password_verify($password, $array['password'])) {
  	if ( $array['isActive'] ) {

      $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
      if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
      }
      if ( $loginQuery = $mysqli->prepare("UPDATE users SET last_login = now() WHERE username = ?") ) {
        /* bind parameters for markers */
        $loginQuery->bind_param("s", $username);
        /* execute query */
        $loginQuery->execute();
        /* close statement */
        $loginQuery->close();
      }
      /* close connection */
      $mysqli->close();
      unset($array['password'], $array['last_login'], $array['isActive'], $array['account_date']);
  		$_SESSION['user'] = $array;
      $_SESSION['viewing_user_id'] = $_SESSION['user']['id'];
  		header('Location: ../../budget.php');
  		die;
  	}
    unset($_SESSION['user']);
  	$_SESSION['feedback'] = [
  		'color' => 'red',
  		'message' =>'It seems that organization is no longer active. Contact the finance chair to update this.'
  	];
  	header('Location: ../../index.php');
  	die;
  }
  else {
    unset($_SESSION['user']);
  	$_SESSION['feedback'] = [
  		'color' => 'red',
  		'message' =>'Wrong Password!'
  	];
  	header('Location: ../../index.php');
  	die;
  }
?>
