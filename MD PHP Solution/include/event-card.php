<div class="event-card">
  <div class="card-top">
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
        Event/Item
      </div>
    </div>
    <div class="card-top-column card-title">
      The Time Of Our Lives Is Now And I Want To Show You
    </div>
    <?php if ( isAdmin() ): ?>
      <div class="visited-button not ripple">Visited</div>
      <div class="delete-button ripple">Delete</div>
    <?php endif; ?>
  </div>
  <div class="card-content">
    <p><span class="detail-heading">Event Name</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Name</span></p>
    <p><span class="detail-heading">Event Type</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Type</span></p>
    <p><span class="detail-heading">Event Date</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Date</span></p>
    <p><span class="detail-heading">Event Location</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Location</span></p>
    <p><span class="detail-heading">Expected Attendance</span><br><span class="detail <?php if ( canEdit() ) { echo 'editable-input'; } ?>">This Number</span></p>
    <hr>
    <p><span class="detail-heading">Event Details</span><br><span class="detail textarea <?php if ( canEdit() ) { echo 'editable-textarea'; } ?>">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae erat aliquam, mollis purus efficitur, congue velit. Mauris ac tincidunt ante,
      vitae luctus felis. Maecenas dictum tristique purus, eget sagittis quam. Mauris eleifend lacus at dolor tempor semper. Mauris ut nisi nisl. Donec ut eros quis ex fringilla maximus. Duis dignissim tincidunt gravida. Etiam nulla ligula, gravida non nisl vel, egestas sagittis nibh. Aenean erat orci, dignissim vitae libero lacinia, elementum ultrices purus. Sed pellentesque, justo vel ornare eleifend, nibh neque porta erat, condimentum porta risus dolor vitae lectus. Mauris at enim nisi. Maecenas id augue nec augue efficitur pharetra. Duis pharetra aliquam ante sed tempor. Quisque vel odio malesuada, porttitor nulla ac, finibus purus. Cras rutrum luctus tellus sed rutrum. Phasellus at ante lectus. Fusce condimentum ex dui, at efficitur turpis vehicula at. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas quis dictum turpis. Donec sed nisl id dui ultrices laoreet. Mauris semper enim et dictum varius.</span></p>
  </div>
</div>
