<?php 
    require "incl/header.php";
?>

<script src="js/jquery.editable.min.js"></script>
<script src="js/jquery.datePicker.js"></script>

<?php
    if ( $_SESSION['user']['role'] != "observe" ) {
        echo '<script src="scripts/dashboard.js"></script><style>.event-edit, .event-edit-date, .event-edit-select, .event-edit-textarea, .event-edit-title, .expenditure-edit, .expenditure-edit-title {cursor: pointer;}</style>';
    }
    else {
        echo '<script src="scripts/dashboard_observe.js"></script>';
    }
?>

<?php if (isLoggedIn()): ?>

    <?php

    // CHECK FOR ADMIN CHANG
    if ( isset($_POST['nextOrg']) ) {
        $_SESSION['viewing_user_id'] = $_POST['nextOrg'];
    }

    // CHECK IF LOGGING IN FOR FIRST TIME
    if (!isset($_SESSION['viewing_user_id'])) {
        $_SESSION['viewing_user_id'] = $_SESSION['user']['id'];
    }

    ?>

    <?php
    
    // Query to check if org_year has been created for most recent year
    $year = sqlQuery("SELECT year_id FROM year ORDER BY year_id DESC;")[0]['year_id'];
    $org_year = sqlQuery("SELECT year_id FROM org_year WHERE org_id = " . $_SESSION['viewing_user_id'] . " ORDER BY year_id DESC;");
    if ( !empty($org_year) ) {
        $org_year = $org_year[0]['year_id'];
    }
    else {
        $org_year = -1;
    }

    if ( $year == $org_year ) :  ?>
    <!-- IF LOGGED IN AND HAS ORG_YEAR -->
        <?php 
            require "incl/dashboard_present.php";
        ?>
    
    <?php else: ?>
    <!-- IF NO ORG_YEAR FOR CURRENT BUDGETING YEAR -->
        <?php require "incl/no_org_year.php"; ?>

    <?php endif; ?>
<!-- END IF LOGGED IN -->

<?php else: ?>
<!-- IF NOT LOGGED IN -->
    <?php require "front_page_logged_out.php"; ?>

<!-- END IF NOT LOGGED IN -->
<?php endif; ?>