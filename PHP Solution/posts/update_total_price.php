<?php
    require "../config.php";
    require "../functions/functions.php";
    session_start();
?>

<?php
    $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
		header('Location: ../index.php');
		die;
	}

	$result = mysqli_query($db, "SELECT SUM(quantity * price) FROM expenditure JOIN event ON expenditure.event_id = event.event_id WHERE event.event_id = " . $_SESSION['event_id'] . " AND expenditure.visible = 1;");

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
		header('Location: ../index.php');
		die;
	}
	
    $row = mysqli_fetch_row($result);
    $sum = $row[0];
    echo "<p><strong>Total Cost Of Event:</strong> $" . number_format($sum,2) . "</p>";
    
	mysqli_close($db);
    
    // END OF TOTAL REQUESTED --- CHECK IF PLEBS CAN SEE ALLOCATED
    $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
		header('Location: ../index.php');
		die;
	}
    
    $newResult = mysqli_query($db, "SELECT done_allocating FROM (SELECT org_year.year_id FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE event.event_id = " . $_SESSION['event_id'] . ") AS dad JOIN year ON year.year_id = dad.year_id ORDER BY done_allocating DESC;");
    
    if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
		header('Location: ../index.php');
		die;
	}
    
    $row = mysqli_fetch_row($newResult);
    $showUserAllocated = $row[0];
	mysqli_close($db);
    
    // IF ALLOWED, SHOW
    
    if ( $showUserAllocated or $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {    
        $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

        if (mysqli_connect_errno($db)) {
            $_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
            header('Location: ../index.php');
            die;
        }

        $result2 = mysqli_query($db, "SELECT SUM(allocated) FROM expenditure JOIN event ON expenditure.event_id = event.event_id WHERE event.event_id = " . $_SESSION['event_id'] . " AND expenditure.visible = 1;");

        if (mysqli_errno($db)) {
            $_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
            header('Location: ../index.php');
            die;
        }
        
        $row2 = mysqli_fetch_row($result2);
        $sum2 = $row2[0];
        
        echo "<p><strong>Total Allocated:</strong> $" . number_format($sum2,2) . "</p>";
    }
?>