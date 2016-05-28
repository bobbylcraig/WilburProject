<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $i = 1;
    $datArray = array();
    parse_str($_POST['item'], $datArray);
    foreach ( $datArray['item'] as $value ) {
        dbQuery("UPDATE `event` SET event_order = " . $i . " WHERE event_id = " . $value . ";");
        $i++;
    }
?>