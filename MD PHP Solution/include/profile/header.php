<div class="header" style="left: 0;">
  <div class="header-wrapper">
    <div class="header-title">
      <nav class="title-dropdown">
        <?php if ( isAdmin() ) { ?>
        <ul>
          <li class="title-style"><a href="#"><?php echo $_SESSION['user']['screenname']; // PRINTS SCREENNAME ?>&nbsp;<span class="year-org">
          <?php echo ' >&nbsp; ' . grabCurrentYear(); ?>
          <?php if ( $_SESSION['user']['id'] != $_SESSION['viewing_user_id'] ) { echo '&nbsp; > &nbsp;' . grabCurrentScreenname(); } ?>
          </span><span class="title-dropdown-option title-caret"></span></a>
            <?php require("headerQueries/isAdmin.php"); ?>
          </li>
        </ul>
        <?php } else { ?>
          <h1>buDUget</h1>
        <?php } ?>
      </nav>
    </div>
    <div class="hamburger-menu">
      <div class="bar"></div>
    </div>
  </div>
</div>
