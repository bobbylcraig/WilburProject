<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $_SESSION['expend_id'] = substr($_POST['expend_id'],12);
    $data = sqlQuery("SELECT expend_name, first_source, second_source, price, quantity, allocated, reason FROM expenditure WHERE expend_id = " . $_SESSION['expend_id'] . ";")[0];
    $show_to_org = sqlQuery("SELECT done_allocating FROM (SELECT org_year.year_id FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE event.event_id = " . $_SESSION['event_id'] . ") AS dad JOIN year ON year.year_id = dad.year_id ORDER BY done_allocating DESC;")[0]['done_allocating'];
?>

<div style="width: 96%; margin-left: 2%;">
    <div class="bs-callout bs-callout-parent">
        <figure class="highlight">
            <?php if (!($_SESSION['user']['role']=="observe")) echo '<div class="zero-clipboard delete-button-expenditure" title="Delete"><span class="btn-clipboard deleteButton">DELETE</span></div>'; ?>
                <h4 id="expend_name" <?php if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) echo 'class="expenditure-edit-title"'; else echo 'style="color: black;"'; ?>><?php echo $data['expend_name']; ?></h4>
                <p>Calculated Cost: <strong><span id="calculated-price"><?php echo '$' . number_format($data['quantity'] * $data['price'],2); ?></span></strong></p>
                <hr>
                <?php
                    if ( $show_to_org or $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {
                        // ALLOCATED
                        echo '<div class="row"><div class="col-md-12"><strong>Total Allocated:</strong><span style="display:block;"><p style="padding-right: 20px; float:left;">$</p><p id="allocated"';
                        if ( $_SESSION['user']['role'] == "admin" ) echo ' class="expenditure-edit';
                        echo '">' . $data['allocated'] . '</p></span></div></div><br>';
                        // REASON
                        echo '<div class="row"><div class="col-md-12"><strong>Reason For Allocation:</strong><p id="reason"';
                        if ( $_SESSION['user']['role'] == "admin" ) echo ' class="expenditure-edit-textarea';
                        echo '" style="white-space: pre-wrap !important; width: 100%;">' . $data['reason'] . '</p></div></div>';
                        echo '<hr>';
                    }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Estimated Price Per Unit:</strong><span style="display:block;"><p style="padding-right: 20px; float:left;">$</p><p id="price" <?php if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" )echo 'class="expenditure-edit"'; ?> style="float:left;"><?php echo $data['price']; ?></p></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Quantity Needed:</strong><p id="quantity" <?php if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) echo 'class="expenditure-edit"'; ?>><?php echo $data['quantity']; ?></p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Price Source 1:</strong><p id="first_source" <?php if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) echo 'class="expenditure-edit"'; ?>><?php echo $data['first_source']; ?></p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Price Source 2:</strong><p id="second_source" <?php if ((!$show_to_org and !($_SESSION['user']['role'] == "observe")) or  $_SESSION['user']['role'] == "admin" ) echo 'class="expenditure-edit"'; ?>><?php echo $data['second_source']; ?></p>
                    </div>
                </div>
        </figure>
    </div>
</div>