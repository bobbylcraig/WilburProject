<div class="header" style="left: 0;">
  <div class="header-wrapper">
    <div class="header-title">
      <nav class="title-dropdown">
        <?php if ( isLoggedIn() ) { ?>
        <ul>
          <li class="title-style"><a href="#"><?php echo $_SESSION['user']['screenname']; // PRINTS SCREENNAME ?>
          <?php echo ' &nbsp;>&nbsp; ' . grabCurrentYear(); ?>
          <?php if ( $_SESSION['user']['id'] != $_SESSION['viewing_user_id'] ) { echo '&nbsp; > &nbsp;' . grabCurrentScreenname(); } ?>
          <span class="title-dropdown-option title-caret"></span></a>
          <?php if ( isFinanceCommittee() ) { require("headerQueries/isFinanceCommittee.php"); }
                else { require("headerQueries/isNotFinanceCommittee.php"); } ?>
          </li>
        </ul>
        <?php } else { ?>
          <h1 style="z-index: 12;">buDUget</h1>
        <?php } ?>
      </nav>
    </div>
    <div class="hamburger-menu">
      <div class="bar"></div>
    </div>
  </div>
</div>
