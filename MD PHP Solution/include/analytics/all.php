<div class="tile desktop-12">
  <h1>All Organization Report</h1>
</div>
<div class="tile desktop-6">
  <div id="canvas-holder">
      <canvas id="chart-area" />
  </div>
</div>
<div class="tile desktop-6">
  <div id="canvas-holder">
      <canvas id="chart-area2" />
  </div>
</div>
<div class="tile desktop-6">
  <div id="canvas-holder">
      <canvas id="chart-area3" />
  </div>
</div>




<script>
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };
    var randomColorFactor = function() {
        return Math.round(Math.random() * 255);
    };
    var randomColor = function(opacity) {
        return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
    };

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#FDB45C",
                    "#949FB1",
                    "#4D5360",
                ],
                label: 'Dataset 3'
            }],
            labels: [
                "Red",
                "Green",
                "Yellow",
                "Grey",
                "Dark Grey"
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Chart.js Doughnut Chart'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myDoughnut = new Chart(ctx, config);
        var ctx2 = document.getElementById("chart-area2").getContext("2d");
        window.myDoughnut = new Chart(ctx2, config);
        var ctx3 = document.getElementById("chart-area3").getContext("2d");
        window.myDoughnut = new Chart(ctx3, config);
    };
    </script>
