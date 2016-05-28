<script src="scripts/dashboard.js"></script>

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
	$category	= mysqli_real_escape_string($db, $_POST['category']);
	
	if (strlen($username) < 3) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Username must be at least 3 characters.'];
		header($location);
		die;
	}
	
	if (strlen($screenname) < 2) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Screenname must be at least 2 characters.'];
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
	$query = sprintf("INSERT INTO users (username, password, screenname, role, category) VALUES ('%s', '%s', '%s', '%s', '%s')", $username, $password, $screenname, $role, $category);
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

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<?php if (isset($_SESSION['feedback'])) {
			echo '<div class="alert alert-danger text-center">' . $_SESSION['feedback']['message'] . '</div>';
			unset($_SESSION['feedback']);
		}
		?>
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
			<span id="pwfeedback"></span>
			<div class="form-group">
				<label for="password2">Repeat Password:</label> 
				<input type="password" name="password2" class="form-control">
			</div>
			<div class="form-group">
				<label for="category">Organization Role (None if not org):</label>
				<select class="form-control" name="category" type="text">
					<option value="None">None (not an org)</option>
					<option value="C3">C3</option>
					<option value="DCA">DCA</option>
					<option value="Events & Traditions">Events & Traditions</option>
					<option value="Fraternity & Sorority">Fraternity & Sorority Life</option>
					<option value="Honoraria & Academic Interests">Honoraria & Academic Interests</option>
					<option value="Media">Media</option>
					<option value="Performing Arts">Performing Arts</option>
					<option value="Social Justice & Advocacy">Social Justice & Advocacy</option>
					<option value="Special Interest">Special Interest</option>
					<option value="Spirit & Club Sports">Spirit & Club Sports</option>
				</select>
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
	header('Location: dashboard.php');
	
	else:
	header('Location: index.php');
	
	endif;
?>