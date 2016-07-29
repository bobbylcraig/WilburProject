<div class="header">
  <div class="header-wrapper">
    <div class="header-title">
      <nav class="title-dropdown">
        <ul>
          <li class="title-style"><a href="#"><?php echo $_SESSION['user']['screenname']; // PRINTS SCREENNAME ?>
          <?php if ( isFinanceCommittee() ) { echo '<span class="title-dropdown-option title-caret"></span>'; } ?></a>
          <?php if ( isFinanceCommittee() ): // PRINTS LIST FOR SWITCHING ?>
            <ul class="title-dropdown-option">
              <li><a href="#">2016-2017</a>
                <ul>
                  <li><a href="">Asian American Association</a></li>
                  <li><a href="#">BSU</a></li>
                  <li><a href="#">Some Other Org</a></li>
                  <li><a href="#">Club Tennis</a></li>
                  <li><a href="#">DUWop</a></li>
                  <li><a href="#">Dad</a></li>
                  <li><a href="#">Mom</a></li>
                  <li><a href="#">Club Tennis</a></li>
                  <li><a href="#">DUWop</a></li>
                  <li><a href="#">Dad</a></li>
                  <li><a href="#">Mom</a></li>
                </ul>
              </li>
              <li><a href="#">2015-2016</a>
                <ul>
                  <li><a href="">Asian American Association</a></li>
                  <li><a href="#">BSU</a></li>
                  <li><a href="#">Some Other Org</a></li>
                  <li><a href="#">Club Tennis</a></li>
                  <li><a href="#">DUWop</a></li>
                </ul>
              </li>
              <li><a href="#">2014-2015</a></li>
            </ul>
      <?php endif; ?>
          </li>
        </ul>
      </nav>
    </div>
    <div class="hamburger-menu">
      <div class="bar"></div>
    </div>
  </div>
</div>
