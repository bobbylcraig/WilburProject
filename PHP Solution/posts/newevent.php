<?php
    session_start();
    ob_start();
    require "../config.php";
    require "../functions/functions.php";
?>

<?php if (isLoggedIn()):
// LOGGED IN

    $data = sqlQuery("SELECT org_year.org_year_id FROM org_year JOIN users ON org_year.org_id = " . $_SESSION['viewing_user_id'] . " ORDER BY org_year_id DESC;");

    if (is_null($data)) {
        header('Location: ../index.php');
    }
    else {
        $order = sqlQuery("SELECT event_order FROM event WHERE org_year_id = 1 ORDER BY event_order DESC;");
        if (!is_null($order)) {
            $next = $order[0]['event_order'] + 1;
        }
        else {
            $next = 1;
        }
        sqlQuery("INSERT INTO `event` (event_name,org_year_id,event_order) VALUES ('New Event','" . $data[0]['org_year_id'] . "'," . $next . ");", "INSERT");
    }
    header('Location: ../index.php');
?>

<?php else:
// NOT LOGGED IN
    header('Location: ../index.php');
    
endif;

ob_end_flush();
?>