<?php $year = dbQuery("SELECT year_id, year_name FROM year WHERE done_allocating = 1 ORDER BY year_id DESC;")[0]; ?>

<?php if (!$year['year_name']): ?> <h1 class="text-center">No Data Yet Available.</h1><h3 class="text-center">Please wait for the first budgeting season to finish.</h3><br> 
<?php endif; ?>
<?php if (isLoggedIn()): ?> <hr><h3 class="text-center">Overview For All Organizations</h3><hr> <?php endif; ?>
<br>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Money By Event Type
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="request-allocate-by-event-type"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-pie-chart fa-fw"></i> Requested By Category
                </div>
                <div class="panel-body">
                    <div id="category-request"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-4 -->
    </div>
</div>


    <?php 
    if ($year['year_id']):
        $cats_cost = dbQuery("SELECT SUM(expenditure.quantity * expenditure.price) AS sum, mom.category, mom.year_id FROM (SELECT dad.category, event.event_id, dad.year_id FROM (SELECT users.category, org_year.org_year_id, org_year.year_id FROM users JOIN org_year ON users.id = org_year.org_id WHERE users.isActive = 1 and org_year.year_id = " . $year['year_id'] . ") AS dad JOIN event ON event.org_year_id = dad.org_year_id WHERE event.visible = 1) AS mom JOIN expenditure ON mom.event_id = expenditure.event_id WHERE expenditure.visible = 1 GROUP BY mom.category;");
    ?>
        <script>
            new Morris.Donut({
            element: 'category-request',
            data: [
                <?php
                if ($cats_cost) {
                    foreach($cats_cost as $cats) {
                        echo '{label: "' . $cats['category'] . '", value: ' . $cats['sum'] . '},';
                    }
                }
                else {
                    echo '{label: "No Data Available", value: 0}';
                }
                ?>
            ],
            colors: ["#CD9B9B", "#8B1A1A", "#FF6666", "#BC8F8F", "#C65D57", "#CC1100", "#DB2929"],
            formatter: function (value, data) { return ('$' + (value).toFixed(2)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }
            });
        </script>
    <?php else: ?>
        <script>
            new Morris.Donut({
            element: 'category-request',
            data: [
                {label: "No Data Available", value: 0}
            ],
            formatter: function (value, data) { return 'N/A'; }
            });
        </script>
    <?php endif; ?>

    <?php 
    if ($year['year_id']):
        $event_type_cost = dbQuery("SELECT SUM(expenditure.quantity * expenditure.price) AS total_request, SUM(expenditure.allocated) AS total_allocated, event.event_type FROM expenditure JOIN (SELECT event.event_id, event.event_type, event.visible FROM event JOIN org_year ON event.org_year_id = org_year.org_year_id WHERE org_year.year_id = " . $year['year_id'] . ") as event ON expenditure.event_id = event.event_id WHERE expenditure.visible = 1 and event.visible = 1 GROUP BY event.event_type;");
    ?>
        <script>
        Morris.Bar({
        element: 'request-allocate-by-event-type',
        data: [
            <?php
            if ($event_type_cost) {
                foreach($event_type_cost as $event) {
                    echo '{ y: "' . $event['event_type'] . '", a: ' . $event['total_request'] . ', b: ' . $event['total_allocated'] . '},';
                }
            }
            else {
                echo '{ y: "No Data Available", a: 0, b: 0 },';
            }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        barColors: ["#CD9B9B", "#8B1A1A"],
        labels: ['Requested', 'Allocated'],
        preUnits: "$"
        });
        </script>
    <?php else: ?>
        <script>
        Morris.Bar({
        element: 'request-allocate-by-event-type',
        data: [
            { y: 'No Data Available', a: 0, b: 0 },
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['No Data']
        });
        </script>
    <?php endif; ?>