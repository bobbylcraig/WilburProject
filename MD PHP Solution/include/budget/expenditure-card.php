<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/config.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/include/functions/functions.php"); ?>
<?php if ( !isLoggedIn() ) { $_SESSION['feedback'] = ['color' => 'red', 'message' =>'Please login to view that page.']; header("Location: /index.php"); die; } ?>
<?php if ( empty($expendInfo) ) { ?>
<div class="event-card">
  <div class="card-content" style="text-align: center;">
    <h2 style="font-weight: 400;">
        No Expenditures
    </h2>
  </div>
</div>
<?php } ?>
<div class="expenditure-card">
  <ul <?php if ( canEdit() ) { echo 'class="sortable-expend list"'; }?>>
    <?php foreach($expendInfo as $expenditure) { ?>
      <li class="collapse-card" id="expend_<?php echo $expenditure['expend_id']; ?>">
        <div class="top">
          <div class="title">
            <div class="card-top-column turn-column">
              <div class="turn-text">
                Requested
              </div>
            </div>
            <div class="card-top-column">
              <div id="expenditure-requested" class="card-price">$
                <?php if ( $expenditure['price'] && $expenditure['quantity'] ) { echo money_format("%!i", $expenditure['price'] * $expenditure['quantity']); } else { echo "0.00"; } ?>
              </div>
            </div>
            <?php if ( isDoneAllocating() ) { ?>
            <div class="card-top-column turn-column">
              <div class="turn-text">
                Allocated
              </div>
            </div>
            <div class="card-top-column">
              <div id="expenditure-allocated" class="card-price">$
                <?php if ( $expenditure['allocated'] ) { echo money_format("%!i", $expenditure['allocated']); } else { echo "0.00"; } ?>
              </div>
            </div>
            <?php } ?>
            <div class="card-top-column turn-column turn-title">
              <div class="turn-text">
                Line Item
              </div>
            </div>
            <div class="card-top-column card-title">
              <?php if ( $expenditure['expend_name'] ) { echo $expenditure['expend_name']; } else { echo "Click below to edit..."; } ?>
            </div>
          </div>
          <span class="collapse-card-title"><i class="material-icons">expand_more</i></span>
        </div>
        <div class="body">
          <?php if ( canEdit() ) { ?><div class="delete-cross" expenditure="<?php echo $expenditure['expend_id']; ?>"><i class="material-icons" tooltip-delete="Delete Expenditure">delete</i></div><?php } ?>
          <p><span class="detail-heading">Expenditure Name</span><br><span number="<?php echo $expenditure['expend_id'] ?>" id="expend_name" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $expenditure['expend_name'] ) { echo $expenditure['expend_name']; } else { echo "Click to edit..."; } ?></span></p>

          <p><span class="detail-heading">Expenditure Quantity</span><br><span number="<?php echo $expenditure['expend_id'] ?>" id="expend_quantity" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $expenditure['quantity'] ) { echo $expenditure['quantity']; } else { echo "Click to edit..."; } ?></span></p>

          <p><span class="detail-heading">Expenditure Price Per Unit</span><br>$<span number="<?php echo $expenditure['expend_id'] ?>" id="expend_price" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $expenditure['price'] ) { echo money_format("%!i", $expenditure['price']); } else { echo "0.00"; } ?></span></p>

          <p><span class="detail-heading">Price Quote 1</span><br><span number="<?php echo $expenditure['expend_id'] ?>" id="expend_price_quote_first" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $expenditure['first_source'] ) { echo $expenditure['first_source']; } ?></span></p>

          <p><span class="detail-heading">Price Quote 2</span><br><span number="<?php echo $expenditure['expend_id'] ?>" id="expend_price_quote_second" class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>"><?php if ( $expenditure['second_source'] ) { echo $expenditure['second_source']; } ?></span></p>

          <?php if ( isDoneAllocating() || isFinanceCommittee() ) { ?>

          <hr>

          <p><span class="detail-heading">Allocation Amount</span><br>$<span number="<?php echo $expenditure['expend_id'] ?>" id="expend_allocation" class="detail <?php if ( isAdmin() ) { echo 'editable-input'; } ?>"><?php if ( $expenditure['allocated'] ) { echo $expenditure['allocated']; } else { echo "0.00"; } ?></span></p>

          <p><span class="detail-heading">Allocation Reason</span><br><span number="<?php echo $expenditure['expend_id'] ?>" id="expend_reason" class="detail textarea <?php if ( isAdmin() ) { echo 'editable-textarea'; } ?>"><?php if ( $expenditure['reason'] ) { echo $expenditure['reason']; } else { echo "Click to edit..."; } ?></span></p>

          <?php } ?>

        </div>
      </li>
    <?php } ?>
  </ul>
</div>
