<section id="welcome">
    <div class="container text-center">
        <?php 
            if (isset($_SESSION['feedback'])) {
                echo '<div style="position: absolute; top: 40px; width: 100%;" class="alert alert-warning">' . $_SESSION['feedback']['message'] . '</div>';
                unset($_SESSION['feedback']);
                session_destroy(); 
            }
        ?>
        <h1>Denison University Budgeting</h1>
        <h3>A DCGA Finance Committee Utility</h3>
    </div>
</section>

<section id="services" class="section-services">
    <div class="container">
        <div class="row text-center">
        <div class="col-md-4">
            <i class="fa fa-area-chart fa-5x"></i>
            <h4>University Catered</h4>
            <p class="text-muted">Made specifically for Denison, buDUget caters to the finance committee's process and allows for easier transparency within the student body.</p>
        </div>
        <div class="col-md-4">
            <i class="fa fa-desktop fa-5x"></i>
            <h4>All In One Place</h4>
            <p class="text-muted">With all of the data being stored in one place, it instantly becomes much more accessible and easier to use.</p>
        </div>
        <div class="col-md-4">
            <i class="fa fa-area-chart fa-5x"></i>
            <h4>Analytics</h4>
            <p class="text-muted">buDUget allows organizations to see visual representations of the previous year's budgets for both the entire student body and their individual organization.</p>
        </div>
    </div>
</section>

<?php require "incl/footer.php"; ?>