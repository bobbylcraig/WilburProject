<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $year = sqlQuery("SELECT year_id FROM year ORDER BY year_id DESC;")[0]['year_id'];
    sqlQuery("UPDATE year SET done_allocating = 1 WHERE year_id = " . $year . ";", "UPDATE"); 
    
    // ADD SCRIPT TO EMAIL ALL ORGANIZATION PRESIDENTS AND TREASURERS
?>