<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
    echo 'daddy';
?>

<?php
    $i = 1;
    $datArray = array();
    parse_str($_POST['item'], $datArray);
    foreach ( $datArray['expenditure'] as $value ) {
        dbQuery("UPDATE `expenditure` SET expend_order = " . $i . " WHERE expend_id = " . $value . ";");
        $i++;
    }
?>