<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $_SESSION['expend_id'] = substr($_POST['expend_id'],12);
    $data = dbQuery("SELECT expend_name, first_source, second_source, price, quantity, allocated, reason FROM expenditure WHERE expend_id = " . $_SESSION['expend_id'] . ";")[0];
?>

<div style="width: 96%; margin-left: 2%;">
    <div class="bs-callout bs-callout-child">
        <figure class="highlight">
            <?php if (!($_SESSION['user']['role']=="observe")) echo '<div class="zero-clipboard delete-button-expenditure" title="Delete"><span class="btn-clipboard">DELETE</span></div>'; ?>
                <h4 id="expend_name" class="expenditure-edit-title"><?php echo $data['expend_name']; ?></h4>
                <p>Calculated Cost: <strong><span id="calculated-price"><?php echo '$' . number_format($data['quantity'] * $data['price'],2); ?></span></strong></p>
                <hr>
                <?php
                    $show_to_org = dbQuery("SELECT done_allocating FROM (SELECT org_year.year_id FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE event.event_id = " . $_SESSION['event_id'] . ") AS dad JOIN year ON year.year_id = dad.year_id ORDER BY done_allocating DESC;")[0]['done_allocating'];
                    if ( $show_to_org or $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {
                        // ALLOCATED
                        echo '<div class="container"><strong>Total Allocated:</strong><p id="allocated"';
                        if ( $_SESSION['user']['role'] == "admin" ) echo ' class="expenditure-edit';
                        echo '">$' . $data['allocated'] . '</p>';
                        // REASON
                        echo '<strong>Reason For Allocation:</strong><p id="reason"';
                        if ( $_SESSION['user']['role'] == "admin" ) echo ' class="expenditure-edit-textarea';
                        echo '" style="white-space: pre-wrap !important;">' . $data['reason'] . '</p></div>';
                        echo '<hr>';
                    }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Estimated Price:</strong><p id="price" class="expenditure-edit"><?php echo '$' . $data['price']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Total Needed:</strong><p id="quantity" class="expenditure-edit"><?php echo $data['quantity']; ?></p>
                    </div>
                </div>
                <br>
                <div class="container">
                    <strong>Price Source 1:</strong><p id="first_source" class="expenditure-edit"><?php echo $data['first_source']; ?></p>
                    <strong>Price Source 2:</strong><p id="second_source" class="expenditure-edit"><?php echo $data['second_source']; ?></p>
                </div>
        </figure>
    </div>
</div>