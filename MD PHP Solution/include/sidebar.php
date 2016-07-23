<div class="sidebar">
  <div class="logo-header">
    <div class="shrink">DU</div>
    <div class="header-wrapper">
      <div class="header-title">
        <a href="index.php">
          bu<span>DU</span>get
        </a>
      </div>
    </div>
  </div>
  <div class="event-area">
    <div class="priority-card">
      <i title="Highest Priority" class="material-icons priority-icon">arrow_upward</i>
      <div class="priority-name">Highest Priority</div>
    </div>
    <ul <?php if ( canEdit() ) { echo 'class="sortable-event list"'; }?>>
      <li class="peak-card">
        <i class="material-icons event-icon">person</i>
        <div class="event-name">First Item That Has A Name That Should Be Addressed</div>
      </li>
      <li class="peak-card">
        <i class="material-icons event-icon">person</i>
        <div class="event-name">First Item That Has A Name That Should Be Addressed</div>
      </li>
      <li class="peak-card">
        <i class="material-icons event-icon">person</i>
        <div class="event-name">First Item That Has A Name That Should Be Addressed</div>
      </li>
    </ul>
    <div class="peak-card">
      <i class="material-icons event-icon">add_circle_outline</i>
      <div class="event-name">Add Event</div>
    </div>
    <div class="priority-card">
      <i title="Lowest Priority" class="material-icons priority-icon">arrow_downward</i>
      <div class="priority-name">Lowest Priority</div>
    </div>
  </div>
</div>
