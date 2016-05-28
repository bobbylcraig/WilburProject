<body>
    <div id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav event-sort sortable list">
                <?php
                    if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {
                        require "incl/change_org.php";
                    }
                    if ( $_SESSION['viewing_user_id'] == $_SESSION['user']['id'] and ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) ) {
                        echo '<p class="text-center">Admins and observers don\'t have budgets.</p>';
                        echo '<p class="text-center">Select an org above to start.</p>';
                    }
                    elseif( $year == $org_year and !($_SESSION['user']['role'] == "observe") ) {
                        echo '<li class="sidebar-brand" id="disabled"><a href="posts/newevent.php">Add Event/Item</a></li>';
                    }
                    $data = dbQuery("SELECT * FROM (SELECT `event`.`event_name`, `event`.`visited`, `org_year`.`org_id`, `event`.`event_id`, `event`.`event_order`, `event`.`visible` FROM `event` JOIN `org_year` ON `org_year`.`org_year_id` = `event`.`org_year_id` WHERE " . $year . " = `org_year`.`year_id`) AS dad WHERE (" . $_SESSION['viewing_user_id'] . " = dad.org_id) AND (dad.visible = 1) ORDER BY `event_order`;");
                    if ( !empty($data) ) {
                        echo "<li id='disabled' style='background: none !important; border: none !important; font-size: 12px !important;'><strong>Highest Priority Items</strong></li>";
                        foreach ( $data as $datum ) {
                            echo "<li class='event-list-item'";
                            if ( ($_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe") AND $datum['visited'] ) {
                                echo " style='border-right-width: 7px; border-right-color: #ce4844;'";
                            }
                            echo "' id='item_" . $datum['event_id'] . "'>" . $datum['event_name'] . "</li>";
                        }
                        echo "<li id='disabled' style='background: none !important; border: none !important; font-size: 12px !important;'><strong>Lowest Priority Items</strong></li>";
                    }
                    else {
                        if ( !($_SESSION['viewing_user_id'] == $_SESSION['user']['id'] and $_SESSION['user']['role'] == "admin") ) {
                            echo "<li id='disabled' style='background: none !important; border: none !important; font-size: 15px !important; margin-top: 30px;'>No Events/Items Added</a></li>";
                        }
                    }
                ?>
            </ul>
        </div>
        <div id="page-content-wrapper">
            <?php
                if (isset($_SESSION['feedback']) and $_SESSION['user']['username'] != '') {
                    echo '<div class="alert alert-success text-center">' . $_SESSION['feedback']['message'] . "</div>";
                    unset($_SESSION['feedback']);
                }
            ?>
            <?php if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {
                echo '<div class="text-center" style="padding: 10px; background:blue; height: 100px; color: white;"><h1>Total Cost And Amount Left Here</h1></div>';
            } ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="aboutEvent">
                            <div class="text-center">
                                <div style="height: 200px;"></div>
                                <h3>Please select an event to get started...</h3>
                                <h4>If you're just starting out, click "Add an Event" to add an event.</h4>
                                <h4>Otherwise, keep working on whatever you were doing last!</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>