<?php 
require "../config.php";
require "../functions/functions.php";

session_start();

$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);

$query = "SELECT * FROM users WHERE username = '$username'";

$user = dbQuery($query);

if (password_verify($password, $user[0]['password'])) {
	$_SESSION['user'] = $user[0];
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