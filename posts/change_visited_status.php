<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    dbQuery("UPDATE event SET visited = " . $_POST['dad'] . " WHERE event_id = " . $_SESSION['event_id'] . ";");
?>