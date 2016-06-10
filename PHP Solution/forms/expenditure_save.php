<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $expend_id      = $_SESSION['expend_id'];
    $field          = $_POST['field'];
    $new_value      = $_POST['value'];
    if ($new_value[0] == "$") {
        $new_value = substr($new_value, 1);
    }
    
    echo $new_value;
    
    $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	/*
	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
		header('Location: ../index.php');
		die;
	}*/

	$result = mysqli_query($db, "UPDATE expenditure SET " . $field . " = '" . addslashes($new_value) . "' WHERE expend_id = " . $expend_id . ";");
	
	/*
	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
		header('Location: index.php');
		die;
	}
	*/
	
	mysqli_close($db);
?>