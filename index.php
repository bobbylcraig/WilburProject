<?php

session_start();

require_once "config.php";
require_once "functions/functions.php";


if (isset($_GET['p'])) {
	$page = $_GET['p'];

	switch ($page) {
		case 'login':
			require "login.php";
			break;
		case 'logout':
			require "logout.php";
			break;
		case 'register':
			require "register.php";
			break;
		case 'profile':
			require "profile.php";
			break;
		case 'dashboard':
			require "dashboard.php";
			break;
		case 'analytics':
			require "analytics.php";
			break;
		case 'indexer':
		default:
			require "indexer.php";
			break;
	}
} else {
	require "indexer.php";
}
?>

		</div> <!-- col-xs-12 -->
	</div> <!-- wrapper -->
</div> <!-- container -->
</body>
</html>