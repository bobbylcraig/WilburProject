<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    dbQuery("UPDATE `event` SET visible = 0 WHERE event_id = " . $_SESSION['event_id'] . ";");
    dbQuery("UPDATE `expenditure` SET visible = 0 WHERE event_id = " . $_SESSION['event_id'] . ";");
?>