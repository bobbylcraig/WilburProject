<?php 

require "incl/header.php";

if (isset($_SESSION['feedback'])) {
	echo '<div class="alert alert-success text-center">' . $_SESSION['feedback']['message'] . " Welcome, " . $_SESSION['feedback']['username'] . "! Login to start working...</div>";
	unset($_SESSION['feedback']);
}
?>

<?php if (isLoggedIn()): ?>
<!-- IF LOGGED IN -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h3>Welcome to buDUget (Logged In)</h3>
			</div>
		</div>
	</div>
<!-- END IF LOGGED IN -->

<?php else: ?>
<!-- IF NOT LOGGED IN -->
    <div id="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Denison Budgeting</h1>
                        <h3>A DCGA Utility</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="https://twitter.com/DenisonU" class="btn btn-default btn-lg"><span class="network-name">Twitter</span></a>
                            </li>
                            <li>
                                <a href="https://facebook.com/DenisonUniversity" class="btn btn-default btn-lg"><span class="network-name">Facebook</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- END IF NOT LOGGED IN -->
<?php endif; ?>