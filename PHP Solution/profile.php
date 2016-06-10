<?php require_once "incl/header.php"; ?>

<?php if (isLoggedIn()): ?>

<div class="container">
	<div class="row">
		<div class="col-lg-12 text-center">
			<h3 class="center-text">Welcome! This is <?php echo $_SESSION['user']['screenname']; ?>'s Profile!</h3>
		</div>
	</div>
</div>

<?php else:
	header('Location: index.php');
?>


<?php endif; ?>