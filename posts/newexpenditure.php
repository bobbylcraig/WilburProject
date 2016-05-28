<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php if (isLoggedIn()):
// LOGGED IN
    $order = dbQuery("SELECT expend_order FROM expenditure WHERE (event_id = " . $_SESSION['event_id'] . ") ORDER BY expend_order DESC;")[0];
    if (!is_null($order)) {
        $next = $order['expend_order'] + 1;
    }
    else {
        $next = 1;
    }
    dbQuery("INSERT INTO `expenditure` (expend_name,event_id,expend_order) VALUES ('New Line Item','" . $_SESSION['event_id'] . "'," . $next . ");");
    header('Location: ../index.php');
?>

<?php else:
// NOT LOGGED IN
    header('Location: ../index.php');
?>

<?php endif; ?>