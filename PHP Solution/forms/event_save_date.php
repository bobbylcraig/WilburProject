<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $event_id       = $_SESSION['event_id'];
    $field          = $_POST['field'];
    $new_value      = $_POST['value'];
    
    sqlQuery("UPDATE event SET " . $field . " = '" . addslashes($new_value) . "' WHERE event_id = " . $event_id . ";", "UPDATE");
?>