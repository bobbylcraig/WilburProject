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
			<div style="margin: 20px 0px 30px 0px;">
				<div class="col-md-6 text-center">
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#newYearModal">
						Create New Budgeting Year
					</button>
				</div>
				<div class="col-md-6 text-center">
					<?php 
						$year = sqlQuery("SELECT year_name, done_allocating FROM year ORDER BY year_id DESC;")[0];
						$year_name = $year['year_name'];
						$done = $year['done_allocating'];
					?>
					<div class="form-group">
						<button type="submit" <?php if (!$done) echo 'id="done_allocating_button"'; else echo 'disabled="disabled"'; ?> class="btn btn-danger">Release <?php echo $year_name; ?> Budget</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<?php require "admin_controls/user_table.php"; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="newYearModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Create New Budget Year</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="form-group">
								<label>New Budgeting Year Name (Ex. 2016-2017)</label>
								<input type="text" class="form-control" id="new-year" name="year-name" placeholder="Ex. 2015-2016" required>
							</div>
							<div class="form-group">
								<label>Budget For New Budgeting Year</label>
								<input type="number" step="0.01" class="form-control" id="new-year-money" name="total-cash" placeholder="Ex. 850000.00" required>
							</div>
							<div class="form-group">
								<label>New Finance Chair's Email</label>
								<input type="text" class="form-control" id="new-year-email" name="email" placeholder="Ex. weinberg_a1@denison.edu" required>
							</div>
							<button type="submit" id="new-year-button" disabled="disabled" class="btn btn-danger">Create</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php else:
	header('Location: index.php');
?>

<?php endif; ?>