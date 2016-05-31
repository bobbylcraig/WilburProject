<?php $year = sqlQuery("SELECT year_id, year_name FROM year WHERE done_allocating = 1 ORDER BY year_id DESC;")[0]; ?>

<?php if (!$year['year_name']): ?> <h1 class="text-center">No Data Yet Available.</h1><h3 class="text-center">Please wait for the first budgeting season to finish.</h3><br> 
<?php endif; ?>

<hr><h3 class="text-center">Overview For <?php echo $user['screenname']; ?></h3><hr>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-line-chart fa-fw"></i> Organization Money By Event Type For <?php echo $year['year_name']; ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="request-allocate-by-event-type-org"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Requested vs Allocated By Year
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="requested-vs-allocated-org"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-6 -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Some Chart -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-6 -->
</div>

    <?php 
    if ($year['year_id']):
        $event_type_cost_org = sqlQuery("SELECT SUM(expenditure.quantity * expenditure.price) AS total_request, SUM(expenditure.allocated) AS total_allocated, event.event_type FROM expenditure JOIN (SELECT org_year.org_year_id, event.event_id, event.event_type, event.visible FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE org_year.year_id = " . $year['year_id'] . " AND org_year.org_id = " . $_SESSION['viewing_user_id'] . ") as event ON expenditure.event_id = event.event_id WHERE expenditure.visible = 1 and event.visible = 1 GROUP BY event.event_type;");
    ?>
        <script>
        Morris.Bar({
        element: 'request-allocate-by-event-type-org',
        data: [
            <?php
            if($event_type_cost_org) {
                foreach($event_type_cost_org as $event_org) {
                    echo '{ y: "' . $event_org['event_type'] . '", a: ' . $event_org['total_request'] . ', b: ' . $event_org['total_allocated'] . '},';
                }
            }
            else {
                echo '{ y: "No Data Available", a: 0, b: 0 },';
            }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        barColors: ["#CD9B9B", "#8B1A1A", "#FF6666", "#BC8F8F", "#C65D57", "#CC1100", "#DB2929"],
        labels: ['Requested', 'Allocated'],
        });
        </script>
    <?php else: ?>
        <script>
        Morris.Bar({
        element: 'request-allocate-by-event-type-org',
        data: [
            { y: 'No Data Available', a: 0, b: 0 },
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['No Data']
        });
        </script>
    <?php endif; ?>

    <?php 
    if ($year['year_id']):
        $requested_vs_allocated_org = sqlQuery("SELECT SUM(expenditure.quantity * expenditure.price) AS total_request, SUM(expenditure.allocated) AS total_allocated, event.year_id FROM expenditure JOIN (SELECT org_year.org_year_id, org_year.year_id, event.event_id, event.visible FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE org_year.org_id = " . $_SESSION['viewing_user_id'] . ") as event ON expenditure.event_id = event.event_id WHERE expenditure.visible = 1 and event.visible = 1 GROUP BY event.year_id;");
    ?>
        <script>
        Morris.Area({
        element: 'requested-vs-allocated-org',
        data: [
            <?php
            if($requested_vs_allocated_org) {
                foreach($requested_vs_allocated_org as $hmm) {
                    $yearName = sqlQuery("SELECT year_name FROM year WHERE year_id = " . $hmm['year_id'] . ";")[0]['year_name'];
                    echo '{ y: "' . $yearName . '", a: ' . $hmm['total_request'] . ', b: ' . $hmm['total_allocated'] . '},';
                }
            }
            else {
                echo '{ y: "No Data Available", a: 0, b: 0 },';
            }
            ?>
        ],
        xkey: 'y',
        lineColors: ["#CD9B9B", "#8B1A1A"],
        ykeys: ['a', 'b'],
        fillOpacity: 0.5,
        labels: ['Requested', 'Allocated'],
        preUnits: "$",
        behaveLikeLine: true
        });
        </script>
    <?php else: ?>
        <script>
        Morris.Area({
        element: 'request-vs-allocated-org',
        data: [
            { y: 'No Data Available', a: 0, b: 0 },
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['No Data', 'No Data']
        });
        </script>
    <?php endif; ?>