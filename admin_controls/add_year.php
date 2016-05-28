<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
		//header('Location: ../index.php');
		die;
	}

	$result = mysqli_query($db, "INSERT INTO year (year_name, total_to_allocate) VALUES ('" . $_POST['new_year'] . "', '" . $_POST['new_year_money'] . "');");

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
		//header('Location: ../index.php');
		die;
	}
	
	mysqli_close($db);
?>