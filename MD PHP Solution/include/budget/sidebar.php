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
  <?php if ( isFinanceCommittee() && $_SESSION['user']['id'] == $_SESSION['viewing_user_id'] ) { ?>
    <div class="event-area">
      <div class="priority-card">
        <div class="priority-name"><h4>Finance Committee Members Cannot Have A Budget.</h4></div>
        <hr class="not-mobile">
        <div class="priority-name">Select an organization to begin budget management.</div>
      </div>
    </div>
  <?php } else { ?>
    <div class="event-area">
      <div class="priority-card">
        <i title="Highest Priority" class="material-icons priority-icon">arrow_upward</i>
        <div class="priority-name">Highest Priority</div>
      </div>
      <ul <?php if ( canEdit() ) { echo 'class="sortable-event list"'; }?>>
        <?php require("sidebarQueries/sidebarQuery.php"); ?>
      </ul>
      <div class="priority-card">
        <i title="Lowest Priority" class="material-icons priority-icon">arrow_downward</i>
        <div class="priority-name">Lowest Priority</div>
      </div>
    </div>
  <?php } ?>
</div>
