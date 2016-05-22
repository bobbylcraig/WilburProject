<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/landing-page.css">

	<link rel="shortcut icon" href="favicon.png">
	
	<title>buDUget</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="scripts/scripts.js"></script>
	<script language="javascript">
        $('.dropdown-toggle').dropdown();
        $('.dropdown-menu').find('form').click(function (e) {
            e.stopPropagation();
        });
    </script>
	<style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"></button>
                <a class="navbar-brand" href="index.php">bu<span style="color: #900000;">DU</span>get</a>
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
														<input type="submit" class="btn btn-primary btn-block" value="Login">
													</div>
											</form>
										</div>
										<div class="bottom text-center">
											Contact <a href="mailto:craig_r1@denison.edu"><b>Bobby Craig</b></a>.
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
									<li><a href="index.php?p=indexer">Dashboard</a></li>
									<li><a href="index.php?p=analytics">Analytics</a></li>
									<li><a href="index.php?p=profile">Profile</a></li>';
									if ($_SESSION['user']['role'] == 'admin') {
										echo '<li><a href="index.php?p=register">Register New Organization</a></li>';
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