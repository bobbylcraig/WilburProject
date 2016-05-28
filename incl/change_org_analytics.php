<?php
    if ( $_SESSION['user']['role'] == "admin" or $_SESSION['user']['role'] == "observe" ) {
        $datGoodData = dbQuery("SELECT id, screenname FROM users WHERE role = 'org';");
        $currentUserQuery = dbQuery("SELECT screenname FROM users WHERE id = " . $_SESSION['viewing_user_id'] . ";")[0];
        echo '
        <li class="sidebar-brand" style="border: none !important;" id="disabled">
            <p style="font-size: 10px; margin-top: -20px; margin-bottom: -10px;">Current: <strong>';
             if ($currentUserQuery['screenname'] == "") {
                 echo 'No Org</strong></p>';
             }
             else {
                echo $currentUserQuery['screenname'] . '</strong></p>';
             }
             echo '
            <form  method="POST" action="index.php?p=analytics">
                <select name="nextOrg" onchange="this.form.submit()" style="width: 80%">
                    <option value="">Select Org To Review...</option>';
                    foreach ( $datGoodData as $datGoodDatum ) {
                        echo '<option value="' . $datGoodDatum['id'] . '">' . $datGoodDatum['screenname'] . '</option>';
                    }
            echo '</select>
            </form>
        </li>';
    }
?>