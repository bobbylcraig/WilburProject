<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
    echo $_SESSION['expend_id'];
?>

<?php    
    $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
		header('Location: ../index.php');
		die;
	}

	$result = mysqli_query($db, "UPDATE `expenditure` SET visible = 0 WHERE expend_id = " . $_SESSION['expend_id'] . ";");

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
		header('Location: ../index.php');
		die;
	}
	
	mysqli_close($db);
?>