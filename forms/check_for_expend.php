<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php

    $result = sqlQuery("SELECT event_type, event_name, expected_attendance, event_date, event_location FROM event WHERE event_id = " . $_SESSION['event_id'] . ";");
    
    if (empty($result)) {
        echo 0;
    }
    elseif ( $result[0]['event_type'] != "Click to edit" and $result[0]['event_name'] != "New Event" and $result[0]['expected_attendance'] != "Click to edit" and $result[0]['event_date'] != "2018/08/01" and $result[0]['event_location'] != "Click to edit" ) {
        echo 1;
    }
    else {
        echo 0;
    }

?>