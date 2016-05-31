<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/simple-sidebar.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/14b09b6881.css">

	<link rel="shortcut icon" href="favicon.png">
	
	<title>buDUget<?php if (isset($_SESSION['page_name'])) echo ' ' . $_SESSION['page_name'];?></title>

	<script src="js/jquery-2-2-3.js"></script>
	<script src="js/jquery-1-11-4.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	<script language="javascript">
        $('.dropdown-toggle').dropdown();
        $('.dropdown-menu').find('form').click(function (e) {
            e.stopPropagation();
        });
    </script>
	<style>
    body {
        padding-top: 70px;
    }
    </style>
</head>

<body>
	<?php
		//error_reporting(0);
		function auto_logout() {
			if ( !isset($_SESSION["user_time"]) ) {
				$_SESSION["user_time"] = time();
				return false;
			}
			$t = time();
			$t0 = $_SESSION["user_time"];
			$diff = $t - $t0;
			if ($diff > 6000 || !isset($t0))
			{          
				return true;
			}
			else
			{
				$_SESSION["user_time"] = time();
			}
		}
		if ( auto_logout() ) {
			session_unset();
			session_destroy();  
			session_start();
			$_SESSION['feedback'] = ['message'=>'Session Timeout... Please Login Again To Continue Budgeting.'];
			header('Location: ../index.php');
			exit;
		}
	?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"></button>
                <a class="navbar-brand lighten-DU" href="index.php">bu<span>DU</span>get</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
					<?php
					if (!isLoggedIn()) {
						echo '<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Login <span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<li>
								<div class="row">
										<div class="col-md-12">
											<form id="loginform" action="forms/sendlogin.php" method="POST">
													<div class="form-group">
														<label for="username">Username: </label>
														<input type="text" class="form-control" name="username">
													</div>
													<div class="form-group">
														<label for="password">Password: </label>
														<input type="password" class="form-control" name="password">
													</div>
													<div class="form-group">
														<input type="submit" class="btn btn-danger btn-block" value="Login">
													</div>
											</form>
										</div>
									</div>
								</li>
							</ul>
						</li>';
					}
					else {
						echo '<li class="dropdown">
								<a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hello, ' . $_SESSION['user']['screenname'] . ' <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="index.php?p=dashboard">Dashboard</a></li>
									<li><a href="index.php?p=analytics">Analytics</a></li>
									<li><a href="index.php?p=profile">Profile</a></li>';
									if ($_SESSION['user']['role'] == 'admin') {
										echo '<li><a href="index.php?p=register">Register New Organization</a></li>';
										echo '<li><a href="index.php?p=admin_controls">Administrator Controls</a></li>';
									}
									echo '<li role="separator" class="divider"></li>
									<li><a href="index.php?p=logout">Logout</a></li>
								</ul>
								</li>';
					}
            ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
</body>