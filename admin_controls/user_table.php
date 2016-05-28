<?php
    $year = dbQuery("SELECT year_id FROM year ORDER BY year_id DESC")[0]['year_id'];
    $org_table = dbQuery("SELECT dad.screenname, dad.category, dad.president, dad.president_email, dad.treasurer, dad.treasurer_email, dad.id FROM ( SELECT * FROM users LEFT JOIN (SELECT * from org_year WHERE org_year.year_id = " . $year . ") AS org_year ON users.id = org_year.org_id WHERE users.isActive = 1 and users.role = 'org' ) AS dad ORDER BY dad.category, dad.screenname;");
    
    if ( !is_null($org_table) ) {
        echo'<table class="table table-striped" style="font-size: 12px;"><thead><tr><th></th><th>Organization</th><th>Category</th><th>President</th><th>President Email</th><th>Treasurer</th><th>Treasurer Email</th></tr></thead><tbody>';
        foreach($org_table as $row) {
            echo '<tr';
            if ( is_null($row['president']) ) {
                echo ' style="background-color: #f2dede;"';
            }
            echo '><td><i org="' . $row['id'] . '" class="glyphicon glyphicon-trash"></i></td><td>' . $row['screenname'] . '</td><td>' . $row['category'] . '</td><td>' . $row['president'] . '</td><td>' . $row['president_email'] . '</td><td>' . $row['treasurer'] . '</td><td>' . $row['treasurer_email'] . '</td></tr>';
        }
        echo '</tbody></table>';
    }
    else {
        echo '<h4 class="text-center">No Organizations Listed</h4>';
    }
?>