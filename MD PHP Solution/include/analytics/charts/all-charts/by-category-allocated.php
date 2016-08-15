<h1>Allocated By Organization Category</h1>
<hr>
<div id="canvas-holder">
    <canvas id="by-category-allocated" />
</div>

<script>
var configByCategoryAllocated = {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [
              <?php
                    foreach ($userCatArray as $userCat) {
                      if ($userCat['requested'] != 0) {
                        echo $userCat['allocated'] . ", ";
                      }
                    };
              ?>
            ],
            backgroundColor: [
              <?php
                    foreach ($userCatArray as $userCat) {
                      if ($userCat['requested'] != 0) {
                        echo "randomColor(), ";
                      }
                    };
              ?>
            ],
            label: "Allocated"
        }],
        labels: [
          <?php
            foreach ($userCatArray as $userCat) {
              if ($userCat['requested'] != 0) {
                echo '"' . $userCat['category'] . '"' . ", ";
              }
            };
          ?>
        ]
    },
    options: {
        responsive: true,
        legend: {
            position: 'right',
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
};
</script>
