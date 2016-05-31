<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $event_id       = $_SESSION['event_id'];
    $field          = $_POST['field'];
    $new_value      = $_POST['value'];
        
    echo $new_value;    
    
    $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
		header('Location: ../index.php');
		die;
	}

	$result = mysqli_query($db, "UPDATE event SET " . $field . " = '" . addslashes($new_value) . "' WHERE event_id = " . $event_id . ";");

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
		header('Location: ../index.php');
		die;
	}
	
	mysqli_close($db);
?>