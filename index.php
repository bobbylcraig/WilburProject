<?php
session_start();
ob_start();
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
		case 'analytics':
			require "analytics.php";
			break;
		case 'admin_controls':
			require "admin_controls.php";
			break;
		case 'dashboard':
		default:
			require "dashboard.php";
			break;
	}
}
else {
	require "dashboard.php";
}
ob_end_flush();
?>

</div>