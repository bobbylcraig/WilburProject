<?php 
require "../config.php";
require "../functions/functions.php";

session_start();

$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);

$user = sqlQuery("SELECT * FROM users WHERE username = '$username'");

if (password_verify($password, $user[0]['password'])) {
	if ( $user[0]['isActive'] ) {
		sqlQuery("UPDATE users SET last_login = now() WHERE username = '$username';", "UPDATE");
		$_SESSION['user'] = $user[0];
		header('Location: ../index.php');
		die;
	}
	$_SESSION['feedback'] = [
		'color' => 'red', 
		'message' =>'It seems that organization is no longer active. Contact the finance chair to update this.'
	];
	$_SESSION['feedback']['username'] = $username; 
	header('Location: ../index.php');
	die;
} else {
	$_SESSION['feedback'] = [
		'color' => 'red', 
		'message' =>'Wrong Password!'
	];
	$_SESSION['feedback']['username'] = $username; 
	header('Location: ../index.php');
	die;
}