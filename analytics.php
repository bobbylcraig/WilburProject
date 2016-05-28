<?php require_once "incl/header.php"; ?>

<?php if (isLoggedIn()): ?>

<?php
    // CHECK FOR ADMIN CHANG
    if ( isset($_POST['nextOrg']) ) {
        $_SESSION['viewing_user_id'] = $_POST['nextOrg'];
    }

    // CHECK IF LOGGING IN FOR FIRST TIME
    if (!isset($_SESSION['viewing_user_id'])) {
        $_SESSION['viewing_user_id'] = $_SESSION['user']['id'];
    }
?>

<body>
	<?php if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ): ?>
        <div id="wrapper">
            <div id="sidebar-wrapper" style="position: fixed;">
                <ul class="sidebar-nav">
                    <?php require "incl/change_org_analytics.php"; ?>
                </ul>
            </div>
            <div id="page-content-wrapper">
            <?php endif; ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Analytics <small>Graphic Overview From Most Recent Budget</small>
                        </h1>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-users fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">26</div>
                                                <div>Organizations</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-calendar fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">12</div>
                                                <div>Items/Events</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-envelope-o fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">124</div>
                                                <div>On Email List</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-cogs fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">13</div>
                                                <div>Years In Use</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php $user = dbQuery("SELECT screenname, role FROM users WHERE id = " . $_SESSION['viewing_user_id'] . ";")[0]; ?>
						<!-- IF AN ADMIN OR OBSERVER, DON'T SHOW INDIVIDUAL REPORT -->
						<?php if ( $user['role'] == "org" ): ?>
							<?php require_once "analytics/individual_org_report.php"; ?>
							
						<?php else: ?>
							<h2 class="text-center"><strong>Click On An Org To See An Individual Report</strong></h2>
						<?php endif; ?>
						    <?php require_once "analytics/all_org_report.php"; ?>
                    </div>
                </div>
            </div>
        <?php if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ): ?> </div> </div> <?php endif; ?>
</body>

<?php else: ?>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                            Analytics <small>Graphic Overview From Most Recent Budget</small>
                        </h1>
                    <?php require_once "analytics/all_org_report.php"; ?>
                </div>
            </div>
        </div>
    </body>
    <br>
    <?php require "incl/footer.php"; ?>


<?php endif; ?>