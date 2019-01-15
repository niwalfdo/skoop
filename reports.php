<?php
    include_once './includes/template.php';
    include_once './includes/dbconn.php';

    $notLogged = true;
    if(@$_SESSION['loggedIn']){$notLogged = false;}
    if($notLogged){header('Location: index.php?operation=logOut');}
    
    $query = $connection->query("SELECT COUNT(state) AS tot, state FROM orders GROUP BY state");
    $statesArray=array();
    $total=0;
    $i=0;
    while ($ordersStateRow = $query->fetch_assoc()){
        $statesArray[$i]['stateName']=$ordersStateRow['state'];
        $statesArray[$i]['stateTotal']=$ordersStateRow['tot'];
        $total=$total+$ordersStateRow['tot']; 
        $i++;      
    }
    $data='';
    foreach($statesArray as $row){
        $percentage=$row['stateTotal']/$total*100;
        $data=$data.'{name: "'.$row['stateName'].'", y: '.$percentage.' }, ';
    }
?>

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $headerLinks; ?> 
            <?php echo $chartsScript; ?>
        </head>
        <body>
            <?php echo str_replace('{{reports}}', 'active', $navBar); ?>
            <div class="container">
                <div class="card">
                    <div class="card-header">Reports</div>
                    <div class="card-body">
                        <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <script> 
                Highcharts.chart('container', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Orders by State'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Totat Orders',
                        colorByPoint: true,
                        data: [<?php echo $data; ?>]
                    }]
                });
            </script>
        </body>
    </html