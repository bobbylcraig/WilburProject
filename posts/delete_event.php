<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    sqlQuery("UPDATE `event` SET visible = 0 WHERE event_id = " . $_SESSION['event_id'] . ";", "UPDATE");
    sqlQuery("UPDATE `expenditure` SET visible = 0 WHERE event_id = " . $_SESSION['event_id'] . ";", "UPDATE");
?>