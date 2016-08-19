<div class="nav-sidebar">
  <ul>
    <a href="/index.php"><li>Home</li></a>
    <a href="/analytics.php"><li>Analytics</li></a>
    <?php if ( isLoggedIn() ) { ?>
    <?php if ( isAdmin() ) { ?>
      <a href="/profile.php"><li>Admin Controls</li></a>
    <?php } else { ?>
      <a href="/profile.php"><li>Profile</li></a>
    <?php } ?>
    <a href="/budget.php"><li>Budgeting</li></a>
    <a href="/collaborations.php"><li>Collaborations</li></a>
    <a href="/include/functions/logout.php"><li>Logout</li></a>
    <?php } ?>
  </ul>
  <div class="footer">
    <p style="text-align: center;">Made by Bobby Craig</p>
    <p style="font-size: 0.8em; text-align: center;"><a href="#">About</a> | <a href="#">Terms and Conditions</a></p>
  </div>
</div>
