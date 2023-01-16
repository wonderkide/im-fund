<?php
use frontend\assets\ChartAsset;
ChartAsset::register($this);

$j_data = json_encode($data);

$this->title = 'สัดส่วนพอร์ต : ' . $port->name;
$this->params['breadcrumbs'][] = ['label' => $port->name, 'url' => ['/fund-port/detail', 'id' => $port->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row justify-content-center">
    <?php /*
    <div class="col-12 col-md-4">
        <div class="chart-wrapper-all">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
     * 
     */
    ?>
    <div class="col-12 col-md-6">
        <canvas id="pieChart" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
    </div>
</div>

<?php
$script = <<< JS
        /*var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
        
        
});*/
        
        var donutData = $j_data
        
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData        = donutData;
        var pieOptions     = {
            maintainAspectRatio : false,
            responsive : true,
        }
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
        
JS;
$this->registerJs($script);
?>