<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
    $_SESSION['event_id'] = substr($_POST['event_id'], 5);
?>

<script>
    function changeColor(element) {
        if ( $(element).hasClass('redButton') ) {
            $(element).text("UNVISITED");
            $(element).removeClass('redButton');
            $(element).addClass('whiteButton');
            var dad = 0;
            $.ajax({
                url: 'posts/get_event.php',
                success: function(data) {
                    data = data.replace(/\s+/g, '');
                    $("#item_" + data).css("border-right-width","");
                    $("#item_" + data).css("border-right-color","");
                }
            });
        }
        else {
            $(element).text("VISITED");
            $(element).addClass('redButton');
            $(element).removeClass('whiteButton');
            var dad = 1;
            $.ajax({
                url: 'posts/get_event.php',
                success: function(data) {
                    data = data.replace(/\s+/g, '');
                    $("#item_" + data).css("border-right-width","7px");
                    $("#item_" + data).css("border-right-color","#ce4844");
                    $("#item_" + data).css("-o-transition","border-right-width .25s ease-in");
                    $("#item_" + data).css("-moz-transition","border-right-width .25s ease-in");
                    $("#item_" + data).css("-webkit-transition","border-right-width .25s ease-in");
                    $("#item_" + data).css("transition","border-right-width .25s ease-in");
                }
            });
        }
        $.ajax({
            data: {'dad': dad},
            type: 'POST',
            url: 'posts/change_visited_status.php',
        });
    }
</script>

<?php
    $show_to_org = sqlQuery("SELECT done_allocating FROM (SELECT org_year.year_id FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE event.event_id = " . $_SESSION['event_id'] . ") AS dad JOIN year ON year.year_id = dad.year_id ORDER BY done_allocating DESC;")[0]['done_allocating'];
?>
<div class="row">
<div class="col-md-9">
    <div class="bs-callout bs-callout-parent">
        <figure class="highlight">
            <!-- FOR ADMIN SHOW SWITCH SLIDER TO CHECK IF VIEWED OR NOT -->
                <?php
                    $data = sqlQuery("SELECT visited FROM event WHERE event_id = " . $_SESSION['event_id'] . ";")[0];
                    if ( $_SESSION['user']['role'] == "admin" AND $data['visited'] == 1 ) {
                        echo '<div style="margin-right: 65px !important;" class="zero-clipboard" title="Delete"><span class="btn-clipboard redButton" onclick="changeColor(this)">VISITED</span></div>';
                        echo '<div class="zero-clipboard delete-button-event" title="Delete"><span class="btn-clipboard deleteButton">DELETE</span></div>';
                    }
                    elseif ( $_SESSION['user']['role'] == "admin" AND $data['visited'] == 0 ) {
                        echo '<div style="margin-right: 65px !important;" class="zero-clipboard" title="Delete"><span class="btn-clipboard whiteButton" onclick="changeColor(this)">UNVISITED</span></div>';
                        echo '<div class="zero-clipboard delete-button-event" title="Delete"><span class="btn-clipboard deleteButton">DELETE</span></div>';
                    }
                    elseif ( $_SESSION['user']['role'] == "org") {
                        echo '<div class="zero-clipboard delete-button-event" title="Delete"><span class="btn-clipboard deleteButton">DELETE</span></div>';
                    }
                ?>
                <?php
                    $_SESSION['event_id'] = substr($_POST['event_id'], 5);
                    $event_info = sqlQuery("SELECT dad.event_name, dad.event_type, dad.event_date, dad.event_location, dad.expected_attendance, dad.past_attendance, dad.details FROM (SELECT event.event_name, event.event_id, event.event_type, event.event_date, event.event_location, event.expected_attendance, event.past_attendance, event.details, org_year.org_id FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id) AS dad JOIN users ON org_id = " . $_SESSION['viewing_user_id'] . " WHERE dad.event_id = " . $_SESSION['event_id'] . ";")[0];
                    // EVENT INFORMATION PRINT OUT
                    echo "<h4 type='name' id='event_name' style='width: 90%;";
                    if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) {
                        echo "' class='event-edit-title'";
                    }
                    else {
                        echo " color: black;'";
                    }
                    echo ">" . $event_info['event_name'] . "</h4>";
                    echo '<hr>';
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="total-event-price"></h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo "<strong>Event Type:</strong> <p style='width: 90%;' id='event_type'";
                        if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) {
                            echo "class='event-edit-select'";
                        } 
                        echo ">" . $event_info['event_type'] . "</p>"; ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo "<strong>Tentative Event Date:</strong> <p style='width: 90%;' id='event_date'";
                        if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) {
                            echo "class='event-edit-date'";
                        }
                        echo ">" . date("Y/m/d", strtotime($event_info['event_date'])) . "</p>" ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo "<strong>Event Location:</strong> <p style='width: 90%;' id='event_location'";
                        if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) {
                            echo "class='event-edit'";
                        }
                        echo ">" . $event_info['event_location'] . "</p>" ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo "<strong>Expected Attendance:</strong> <p style='width: 90%;' id='expected_attendance'";
                        if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) {
                            echo "class='event-edit'";
                        }
                        echo ">" . $event_info['expected_attendance'] . "</p>" ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo "<strong>Event Details/Argument:</strong><br><br><p style='white-space: pre-wrap !important;' id='details'";
                        if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) {
                            echo "class='event-edit-textarea'";
                        }
                        echo ">" . $event_info['details'] . "</p>"; ?>
                    </div>
                </div>
                <br>
        </figure>
    </div>
    <div class="aboutExpenditure"></div>
</div>
<div class="col-md-3">
    <ul id="expenditure-sidebar" style="width: 90%;" class="sidebar-nav expenditure-sort sortable list">
        <?php if ( !($_SESSION['user']['role'] == "observe") ) {
            echo '<li class="sidebar-brand add-line-item" id="disabled"><a>Add Line Item To Event</a></li>';
        }
        ?>
        <?php
            $data = sqlQuery("SELECT expend_id, expend_name FROM expenditure WHERE (visible = 1) AND event_id = " . $_SESSION['event_id'] . " ORDER BY expend_order ASC;");
            if ( !empty($data) ) {
                echo "<li id='disabled' style='background: none !important; border: none !important; font-size: 12px !important;'><strong>Highest Priority Items</strong></li>";
                foreach ( $data as $datum ) {
                    echo "<li class='expenditure-list-item' id='expenditure_" . $datum['expend_id'] . "'>" . $datum['expend_name'] . "</li>";
                }
                echo "<li id='disabled' style='background: none !important; border: none !important; font-size: 12px !important;'><strong>Lowest Priority Items</strong></li>";
            }
            else {
                echo "<li id='disabled' style='background: none !important; border: none !important; font-size: 12px !important; margin-top: 30px;'>No Line Items For This Event/Item</li>";
            }
        ?>
    </ul>
</div>
</div>