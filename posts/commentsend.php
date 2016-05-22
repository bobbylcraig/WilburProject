<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	require_once "../config.php";
	require_once "../functions/functions.php";
	$error = false;

	$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
	if ($mysqli->connect_errno) {
	    print "Kunde inte ansluta till databasen (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$stmt = $mysqli->prepare("INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)");
	$stmt->bind_param('iis', $user_id, $post_id, $content);


	// VALIDATION
	if (strlen($_POST['content']) <= 2000 && strlen($_POST['content']) > 3) {
		$content = $mysqli->real_escape_string($_POST['content']);
	} else {
		$error = true;
		$_SESSION['feedback'] = ['color' => 'red', 'message' =>'Kommentaren måste vara mellan 3 och 2000 tecken'];
		
	}

	$user_id = $_SESSION['user']['id'];
	$post_id = $_SESSION['commentOnPost'];

	if (!$error) {
		if (!$stmt->execute()) {
			print $mysqli->error;
			die;
		}
	} else {
		header("Location: ../index.php?p=post&id=$post_id");
		die;
	}
	$stmt->close();

	$mysqli->close();

} // if post

$_SESSION['feedback'] = ['color' => 'green', 'message' =>'Kommentaren skickad!'];
header("Location: ../index.php?p=post&id=$post_id");
die;