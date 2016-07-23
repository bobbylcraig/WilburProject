<?php if (isset($_SESSION['feedback'])): ?>
  <style>
    .notice {
      font-family: 'Roboto', Helvetica, Arial, sans-serif;
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
      margin: 0;
      color: white;
      font-size: .9em;
      line-height: 1.4;
      <?php
      switch ($_SESSION['feedback']['color']) {
        case 'red':
            echo "background: #f33535;";
            break;
        case 'yellow':
            echo "background: #fbb323;";
            break;
        case 'green':
            echo "background: #2ee08a;";
            break;
        case 'blue':
            echo "background: #3ebaef;";
            break;
        default:
            echo "background: #fbb323;";
      }
      ?>
    }
    .notice > .icon {
      -webkit-box-align: center;
      -webkit-align-items: center;
          -ms-flex-align: center;
              align-items: center;
      background: rgba(0, 0, 0, 0.2);
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
      -webkit-justify-content: center;
          -ms-flex-pack: center;
              justify-content: center;
      width: 3.5em;
    }
    .notice > .icon path {
      fill: white;
    }
    .notice > p {
      -webkit-box-flex: 1;
      -webkit-flex: 1;
          -ms-flex: 1;
              flex: 1;
      margin: 0;
      padding: 1em 1em .9em;
    }
  </style>

  <div class="notice">
    <div class="icon">
        <svg style="height:1.8em; width:1.8em;" viewBox="0 0 13 16" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.3 5.69c-0.19-0.19-0.28-0.42-0.28-0.7s0.09-0.52 0.28-0.7 0.42-0.28 0.7-0.28 0.52 0.09 0.7 0.28 0.28 0.42 0.28 0.7-0.09 0.52-0.28 0.7-0.42 0.3-0.7 0.3-0.52-0.11-0.7-0.3z m1.7 2.3c-0.02-0.25-0.11-0.48-0.31-0.69-0.2-0.19-0.42-0.3-0.69-0.31h-1c-0.27 0.02-0.48 0.13-0.69 0.31-0.2 0.2-0.3 0.44-0.31 0.69h1v3c0.02 0.27 0.11 0.5 0.31 0.69 0.2 0.2 0.42 0.31 0.69 0.31h1c0.27 0 0.48-0.11 0.69-0.31 0.2-0.19 0.3-0.42 0.31-0.69h-1V7.98z m-1-5.69C3.86 2.3 1.3 4.84 1.3 7.98s2.56 5.7 5.7 5.7 5.7-2.55 5.7-5.7-2.56-5.69-5.7-5.69m0-1.31c3.86 0 7 3.14 7 7S10.86 14.98 7 14.98 0 11.86 0 7.98 3.14 0.98 7 0.98z" />
        </svg>
    </div>
    <p><?php echo $_SESSION['feedback']['message']; ?></p>
  </div>
  <?php unset($_SESSION['feedback']); ?>
  <?php session_destroy(); ?>
<?php endif; ?>
