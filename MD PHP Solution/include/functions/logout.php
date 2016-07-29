<?php
  session_start();
  session_destroy();
  session_start();
  $_SESSION['feedback'] = [
    'color' => 'green',
    'message' =>'You have successfully logged out!'
  ];
  header("Location: ../../index.php");
?>
