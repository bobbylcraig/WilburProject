<?php
    session_start();
    ob_start();
    require "../config.php";
    require "../functions/functions.php";

if (isLoggedIn()):
// LOGGED IN
    $order = sqlQuery("SELECT expend_order FROM expenditure WHERE (event_id = " . $_SESSION['event_id'] . ") ORDER BY expend_order DESC;")[0];
    if (!is_null($order)) {
        $next = $order['expend_order'] + 1;
    }
    else {
        $next = 1;
    }
    sqlQuery("INSERT INTO `expenditure` (expend_name,event_id,expend_order) VALUES ('New Line Item','" . $_SESSION['event_id'] . "'," . $next . ");", "UPDATE");
    header('Location: ../index.php');
?>

<?php else:
// NOT LOGGED IN
    header('Location: ../index.php');

endif;

ob_end_flush();
?>