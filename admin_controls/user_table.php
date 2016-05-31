<div class="row">
    <div class="col-md-12">
        <hr>
        <h3 class="text-center">Active Organizations</h3>
        <hr>

<?php
    $year = sqlQuery("SELECT year_id FROM year ORDER BY year_id DESC")[0]['year_id'];
    $org_table = sqlQuery("SELECT dad.screenname, dad.category, dad.president, dad.president_email, dad.treasurer, dad.treasurer_email, dad.id FROM ( SELECT * FROM users LEFT JOIN (SELECT * from org_year WHERE org_year.year_id = " . $year . ") AS org_year ON users.id = org_year.org_id WHERE users.isActive = 1 and users.role = 'org' ) AS dad ORDER BY dad.category, dad.screenname;");
    
    if ( !empty($org_table) ) {
        echo'<table class="table table-striped" style="font-size: 12px;"><thead><tr><th></th><th>Organization</th><th>Category</th><th>President</th><th>President Email</th><th>Treasurer</th><th>Treasurer Email</th></tr></thead><tbody>';
        foreach($org_table as $row) {
            echo '<tr';
            if ( is_null($row['president']) ) {
                echo ' style="background-color: #f2dede;"';
            }
            echo '><td><i org="' . $row['id'] . '" class="glyphicon glyphicon-trash organizationDelete"></i></td><td>' . $row['screenname'] . '</td><td>' . $row['category'] . '</td><td>' . $row['president'] . '</td><td>' . $row['president_email'] . '</td><td>' . $row['treasurer'] . '</td><td>' . $row['treasurer_email'] . '</td></tr>';
        }
        echo '</tbody></table>';
    }
    else {
        echo '<br><div class="alert alert-danger" role="alert">No Active Orgs</div>';
    }
    ?>
    
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <hr>
            <h3 class="text-center">Observers, Admins, and Controllers</h3>
        <hr>
    
    <?php
    $user_table = sqlQuery("SELECT username, screenname, role, id FROM users WHERE role != 'org' ORDER BY role;");
    
    if ( !empty($user_table) ) {
        echo'<table class="table table-striped" style="font-size: 12px;"><thead><tr><th></th><th>Name</th><th>Role</th></tr></thead><tbody>';
        foreach($user_table as $row) {
            echo '<tr><td>';
            if ( $row['username'] != "bobbylcraig" ) echo '<i org="' . $row['id'] . '" class="glyphicon glyphicon-trash userDelete"></i>';
            echo '</td><td>' . $row['screenname'] . '</td><td>';
            if ( $row['role'] == 'admin' ) echo "Administrator";
            elseif ( $row['role'] == 'observe' ) echo "Observer";
            else echo "Controller";
            echo '</td></tr>';
        }
        echo '</tbody></table>';
    }
    else {
        echo '<br><div class="alert alert-danger" role="alert">No Users</div>';
    }
?>

    </div>
    <div class="col-md-6">
        <hr>
            <h3 class="text-center">Deactivated Organizations</h3>
        <hr>
    
    <?php
    $inactive_org_table = sqlQuery("SELECT screenname, id FROM users WHERE role = 'org' and isActive = 0 ORDER BY screenname;");
    
    if ( !empty($inactive_org_table) ) {
        echo'<table class="table table-striped" style="font-size: 12px;"><thead><tr><th></th><th>Name</th></tr></thead><tbody>';
        foreach($inactive_org_table as $row) {
            echo '<tr><td><i org="' . $row['id'] . '" class="glyphicon glyphicon-plus orgAdd"></i></td><td>' . $row['screenname'] . '</td></tr>';
        }
        echo '</tbody></table>';
    }
    else {
        echo '<br><div class="alert alert-danger" role="alert">No Inactive Orgs</div>';
    }
?>

    </div>
</div>