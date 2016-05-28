<?php 
require_once "config.php";
require_once "functions/functions.php";
require_once "incl/header.php";
?>

<script src="scripts/admin_controls.js"></script>

<?php if ( isLoggedIn() and $_SESSION['user']['role'] == "admin" ): ?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header"><?php echo $_SESSION['user']['screenname']; ?>'s Admin Panel <small>Use With Care...</small></h2>
			<br>
			
			<div style="margin: 20px 0px 30px 0px;" class="row">
				<div class="col-lg-6 text-center">
					<form class="form-inline">
						<div class="form-group">
							<input type="text" class="form-control" id="new-year" name="year-name" placeholder="Ex. 2015-2016">
						</div>
						<div class="form-group">
							<input type="number" step="0.01" class="form-control" id="new-year-money" name="total-cash" placeholder="Ex. 850000.00">
						</div>
						<button type="submit" id="new-year-button" disabled="disabled" class="btn btn-danger">Create</button>
					</form>
				</div>
				<div class="col-lg-6 text-center">
					<?php 
						$year = dbQuery("SELECT year_name, done_allocating FROM year ORDER BY year_id DESC;")[0];
						$year_name = $year['year_name'];
						$done = $year['done_allocating'];
					?>
					<button type="submit" <?php if (!$done) echo 'id="done_allocating_button"'; else echo 'disabled="disabled"'; ?> class="btn btn-danger">Release The <?php echo $year_name; ?> Budget To Orgs</button>
				</div>
			</div>
			
			<?php
				require "admin_controls/user_table.php";
			?>
		</div>
	</div>
</div>

<?php else:
	header('Location: index.php');
?>

<?php endif; ?>