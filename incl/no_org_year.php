<?php
    if ( isset($_SESSION['feedback']) and $_SESSION['feedback']['message'] == 'Wrong Password!' ) { unset($_SESSION['feedback']); };

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $location = 'Location: index.php?p=dashboard';
        
        if ( $_SESSION['user']['id'] != $_SESSION['viewing_user_id'] ) {
            $_SESSION['feedback'] = ['color'=>'red', 'message'=>'This is not your organization. Please tell the organization whose page you are on to enter this info to view their budget.'];
            header($location);
            die;
        }

        $db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

        if (mysqli_connect_errno($db)) {
            $_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database. Contact Bobby Craig.'];
            header($location);
            die;
        }

        $presidentname  	= mysqli_real_escape_string($db, $_POST['president-name']);
        $presidentemail	    = mysqli_real_escape_string($db, $_POST['president-email']);
        $treasurername 	    = mysqli_real_escape_string($db, $_POST['treasurer-name']);
        $treasureremail 	= mysqli_real_escape_string($db, $_POST['treasurer-email']);
        
        if ( !preg_match("/^[a-z]{1,6}_[a-z]\d{1,2}/", $presidentemail) ) {
            $_SESSION['feedback'] = ['color'=>'red', 'message'=>'The president\'s email is not a valid email.'];
            header($location);
            die;
        }
        else if ( !preg_match("/^[a-z]{1,6}_[a-z]\d{1,2}/", $treasureremail) ) {
            $_SESSION['feedback'] = ['color'=>'red', 'message'=>'The treasurer\'s email is not a valid email.'];
            header($location);
            die;
        }
        else {
            $presidentemail = $presidentemail . "@denison.edu";
            $treasureremail = $treasureremail . "@denison.edu";
        }
        
        // then insert
        $query = sprintf("INSERT INTO org_year (org_id, year_id, president, president_email, treasurer, treasurer_email) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $_SESSION['user']['id'], $year, $presidentname, $presidentemail, $treasurername, $treasureremail);
        $result = mysqli_query($db, $query);
        
        if (mysqli_errno($db)) {
            $_SESSION['feedback'] = ['color'=>'red', 'message'=>'Registration failed.'];
            header($location);
            die;
        } else {
            $_SESSION['feedback'] = ['color'=>'green', 'message'=>'Registration successful! Go on with your budgeting.'];
            header('Location: index.php');
            die;
        }
        
        unset($_POST['president-name']);
        unset($_POST['president-email']);
        unset($_POST['treasurer-name']);
        unset($_POST['treasurer-email']);
    } // if post
?>

<body>
    <div id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav event-sort sortable list">
                <?php
                    if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {
                        require "incl/change_org.php";
                    }
                    else {
                        echo '<li class="sidebar-brand text-center" style="border: none !important; margin-left: -20px;" id="disabled">No Data</li>';
                    }
                ?>
            </ul>
        </div>
        <div id="page-content-wrapper">
            <?php
                if (isset($_SESSION['feedback'])) {
                    echo '<div class="alert alert-warning text-center">' . $_SESSION['feedback']['message'] . '</div>';
                    unset($_SESSION['feedback']);
                }
            ?>
            <?php
                if ( !(($_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe") and $_SESSION['user']['id'] == $_SESSION['viewing_user_id']) ):
            ?>
                <?php if ( $_SESSION['user']['id'] == $_SESSION['viewing_user_id'] ): ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <h1 class="text-center">The Specified Information Needs To Be Entered For This Budgeting Season</h1>
                            <hr>
                            <form id="registerform" action="index.php?p=dashboard" method="POST">
                                <div class="form-group">
                                    <label for="president-name">President's Name:</label>
                                    <input type="text" placeholder="Ex. Robert Craig" name="president-name" class="form-control" required>
                                </div>
                                <p id="president-email-fail" style="color:red; display: none;">This doesn't match the form of a Big Red ID</p>
                                <div class="form-group">
                                    <label for="president-email">President's Email:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="president-email" placeholder="Ex. craig_r1" aria-describedby="basic-addon2" required>
                                        <span class="input-group-addon" id="basic-addon2">@denison.edu</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="treasurer-name">Treasurer's Name:</label>
                                    <input type="text" placeholder="Ex. Robert Craig" name="treasurer-name" class="form-control" required>
                                </div>
                                <p id="treasurer-email-fail" style="color:red; display: none;">This doesn't match the form of a Big Red ID</p>
                                <div class="form-group">
                                    <label for="treasurer-email">Treasurer's Email:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="treasurer-email" placeholder="Ex. craig_r1" aria-describedby="basic-addon2" required>
                                        <span class="input-group-addon" id="basic-addon2">@denison.edu</span>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-default" value="Register!">
                            </form>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center">Notify This Student Organization That They Need To Start This Year's Budget</h2>
                        </div>
                    </div>
                
                <?php endif; ?>
                
            <?php else: ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h2 class="text-center">Admins and observers cannot have a budget.</h2>
                        <h3 class="text-center">Select an org on the left to begin.</h3>
                    </div>
                </div>
            
            <?php endif; ?>
        </div>
    </div>
</body>