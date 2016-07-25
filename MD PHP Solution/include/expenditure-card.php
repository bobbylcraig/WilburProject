<div class="expenditure-card">
  <div class="collapse-card-add ripple" title="Add An Expenditure">
    <div class="title">
      <i class="material-icons">add_circle_outline</i>
    </div>
  </div>

  <ul <?php if ( canEdit() ) { echo 'class="sortable-expend list"'; }?>>

    <li class="collapse-card" id="item_2">
      <div class="top">
        <div class="title">
          <div class="card-top-column turn-column">
            <div class="turn-text">
              Requested
            </div>
          </div>
          <div class="card-top-column">
            <div class="card-price">$43.23</div>
          </div>
          <div class="card-top-column turn-column">
            <div class="turn-text">
              Allocated
            </div>
          </div>
          <div class="card-top-column">
            <div class="card-price">$21.62</div>
          </div>
          <div class="card-top-column turn-column turn-title">
            <div class="turn-text">
              Line Item
            </div>
          </div>
          <div class="card-top-column card-title">
            Expenditure 2 Which I plan on telling you about right at this moment
          </div>
        </div>
        <span class="collapse-card-title"><i class="material-icons">expand_more</i></span>
      </div>
      <div class="body">
        <div class="delete-cross"><i class="material-icons">delete</i></div>
        <p><span class="detail-heading">Expenditure Name</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Type</span></p>
        <p><span class="detail-heading">Expenditure Quantity</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Date</span></p>
        <p><span class="detail-heading">Expenditure Price Per Unit</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Location</span></p>
        <p><span class="detail-heading">Price Quote 1</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Number</span></p>
        <p><span class="detail-heading">Price Quote 2</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Number</span></p>
      </div>
    </li>

  </ul>
</div>
