<?php if (isLoggedIn() and $_SESSION['user']['role'] == 'admin'):

$username = "";
$screenname = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$location = 'Location: index.php?p=register';

	$db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database. Contact Bobby Craig.'];
		header($location);
		die;
	}

	$username 	= mysqli_real_escape_string($db, $_POST['username']);
	$screenname	= mysqli_real_escape_string($db, $_POST['screenname']);
	$password 	= mysqli_real_escape_string($db, $_POST['password']);
	$password2 	= mysqli_real_escape_string($db, $_POST['password2']);
	$role 		= mysqli_real_escape_string($db, $_POST['role']);
	
	if (strlen($username) < 3) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Username must be at least 3 characters.'];
		header($location);
		die;
	}
	
	if (strlen($screenname) < 5) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Screenname must be at least 5 characters.'];
		header($location);
		die;
	}

	//check if user exists
	$query = sprintf("SELECT username FROM users where username='%s'", $username);

	$result = mysqli_query($db, $query);
	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Registration failed. Try again..'];
		header($location);
		die;
	} else {
		if (mysqli_num_rows($result)>0) {
			$_SESSION['feedback'] = ['color'=>'red', 'message'=>'That user name is already taken.'];
			header($location);
			die;
		}
	}

	// Password check
	if (strlen($password) < 6) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Passwords must be at least 6 characters long.'];
		header($location);
		die;
	}

	if ($password != $password2) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Passwords must match.'];
		header($location);
		die;
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	// then insert
	$query = sprintf("INSERT INTO users (username, password, screenname, role) VALUES ('%s', '%s', '%s', '%s')", $username, $password, $screenname, $role);
	$result = mysqli_query($db, $query);

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Registration Failed.'];
		header($location);
		die;
	} else {
		$_SESSION['feedback'] = ['color'=>'green', 'message'=>'Registration successful!', 'username'=>$username];
		header('Location: index.php');
		die;
	}
} // if post
?>

<?php require "incl/header.php"; ?>

<?php if (isset($_SESSION['feedback'])) {
	echo '<div class="alert alert-danger">' . $_SESSION['feedback']['message'] . '</div>';
	unset($_SESSION['feedback']);
}
?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">

		<form id="registerform" action="index.php?p=register" method="POST">
			<div class="form-group">
				<label for="username">Username:</label>
				<input type="text" name="username" class="form-control" value="<?php print $username; ?>" required>
			</div>
			<div class="form-group">
				<label for="screenname">Full Organization Name (or screenname if not org):</label>
				<input type="text" name="screenname" class="form-control" value="<?php print $screenname; ?>" required>
			</div>
			<div class="form-group">
				<label for="password">Password:</label> 
				<input type="password" name="password" class="form-control">
			</div>
			<div class="form-group">
				<label for="password2">Repeat Password:</label> 
				<input type="password" name="password2" class="form-control">
			</div>
			<div class="form-group">
				<label for="role">New User Role:</label>
				<select class="form-control" name="role" type="text">
					<option value="org">Organization</option>
					<option value="controller">Controller</option>
					<option value="admin">Administrator</option>
					<option value="observe">Observer</option>
				</select>
			</div>
			<div id="feedback"></div>
			<input type="submit" class="btn btn-default" value="Register!">
		</form>
	</div>
</div>

<?php elseif(isLoggedIn()):
	header('Location: indexer.php');
	
	else:
	header('Location: index.php');
	
	endif;
?>