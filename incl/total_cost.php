<?php
    if (!isset($_SESSION)) {
        session_start();
        require_once "../config.php";
        require_once "../functions/functions.php";
    }
    else {
        require_once "config.php";
        require_once "functions/functions.php";
    }
?>

<?php 
    $year = sqlQuery("SELECT year_id FROM year ORDER BY year_id DESC;")[0]['year_id'];
    $amount = sqlQuery("SELECT total_to_allocate FROM year WHERE year_id = " . $year . ";")[0]['total_to_allocate'];
    $sum = sqlQuery("SELECT sum(expenditure.allocated) AS sum FROM expenditure JOIN (SELECT event_id FROM event JOIN (SELECT org_year_id FROM org_year JOIN year ON org_year.year_id = year.year_id WHERE year.year_id = " . $year . ") AS org_year ON org_year.org_year_id = event.org_year_id) AS event ON event.event_id = expenditure.event_id WHERE visible = 1;")[0]['sum'];
    echo "$" . number_format($amount - $sum,2);
?>