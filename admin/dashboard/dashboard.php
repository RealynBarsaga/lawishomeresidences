<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header('Location: ../../admin/login.php');
        exit; // Ensure no further execution after redirect
    }
    include('../../admin/head_css.php'); 
?>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="skin-black">
    <?php
    include "../../admin/connection.php";
    include('../../admin/header.php');
    ?>
    <style>
        .info-box {
            display: block;
            min-height: 125px;
            background: #fff;
            width: 92%;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            border-radius: 2px;
            margin-bottom: 15px;
        }
        .info-box-text {
            text-transform: none;
            font-weight: 100;
        }
        .chart-container {
            margin-left: 400px;
            margin-top: 100px; /* Adjust as needed */
        }
        .chart-containers {
            margin-left: 509px;
            margin-top: -304px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 48%;
            height: 300px;
            background: rgb(255, 255, 255);
            box-sizing: border-box;
            padding: -8px;       
        }
        canvas#myPieChart { /* Fixed the CSS issue here */
            display: block;
            box-sizing: border-box;
            height: 307px;
            width: 380px;
        }
    </style>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include('../../admin/sidebar-left.php'); ?>

        <aside class="right-side">
            <section class="content-header">
                <h1>Dashboard</h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="box">
                        <!-- Info Boxes -->
                        <?php
                        $info_boxes = [
                            ['label' => 'Madridejos Officials', 'icon' => 'fa-user', 'color' => '#00c0ef', 'query' => "SELECT * FROM tblMadofficial", 'link' => '../../officials/officials.php'],
                            ['label' => 'Total Barangay', 'icon' => 'fa-university', 'color' => '#007256', 'query' => "SELECT * FROM tblstaff", 'link' => '../../staff/staff.php'],
                            ['label' => 'Total Permit', 'icon' => 'fa-file', 'color' => '#bd1e24', 'query' => "SELECT * FROM tblpermit", 'link' => '../../permit/permit.php'],
                            ['label' => 'Total Household', 'icon' => 'fa-users', 'color' => '#e5c707', 'query' => "SELECT * FROM tblhousehold", 'link' => '../../householdlist/householdlist.php']
                        ];
                        foreach ($info_boxes as $box) {
                            $q = mysqli_query($con, $box['query']);
                            $num_rows = mysqli_num_rows($q);
                        ?>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <br>
                            <div class="info-box" style="margin-left: 9px; background-color: <?= $box['color'] ?> !important;">
                                <span style="background: transparent; position: absolute; top: 47%; left: 77%; transform: translate(-50%, -50%); font-size: 40px; color: #eeeeeeba; z-index: 1;">
                                    <i class="fa <?= $box['icon'] ?>"></i>
                                </span>
                                <span class="info-box-number" style="font-size: 30px; color: #fff; margin-left: 15px; font-family: 'Source Sans Pro', sans-serif; font-weight: bold;">
                                    <?= $num_rows ?>
                                    <span class="info-box-text"><?= $box['label'] ?></span>
                                </span>
                                <div class="info-box-footer" style="margin-top: 35px; text-align: center; background-color: rgba(0, 0, 0, 0.1); padding: 5px; cursor: pointer; z-index: 999; position: relative;">
                                    <a href="<?= $box['link'] ?>" style="color: #fff; text-decoration: none; font-weight: 100; font-family: 'Source Sans Pro', sans-serif;">
                                        More Info <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div><!-- /.box -->
                    <!-- Bar Chart -->
                    <div class="chart-container" style="margin-left: 22px;">
                        <canvas id="myBarChart" width="100" height="30" style="max-width: 45%;background: #fff;"></canvas>
                    </div>

                    <!-- Pie Chart -->
                    <div class="chart-containers">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div><!-- /.row -->
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
    
    <?php
    // Query to count data for each barangay
    $barangays = ['Tabagak', 'Bunakan', 'Kodia', 'Talangnan', 'Poblacion', 'Maalat', 'Pili', 'Kaongkod', 'Mancilang', 'Kangwayan', 'Tugas', 'Malbago', 'Tarong', 'San Agustin'];
    $counts = [];

    foreach ($barangays as $barangay) {
        $q = mysqli_query($con, "SELECT * FROM tblhousehold WHERE barangay = '$barangay'"); // Corrected table name
        $counts[] = mysqli_num_rows($q);
    }
    ?>

    <script>
        const barCtx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($barangays) ?>,
                datasets: [{
                    label: 'Count',
                    data: <?= json_encode($counts) ?>,
                    backgroundColor: [
                        '#4CB5F5',
                    ],
                    borderColor: [
                        '#4CB5F5',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Household Overview',
                        font: {
                            size: 18
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Pie chart
        const pieCtx = document.getElementById('myPieChart').getContext('2d');
        const myPieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($barangays) ?>,
            datasets: [{
                label: 'Households',
                data: <?= json_encode($counts) ?>,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40',
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40',
                    '#FF6384',
                    '#36A2EB'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left', // Position the legend on the right
                    labels: {
                        boxWidth: 15, // Make legend boxes smaller
                        padding: 6,  // Spacing between legend items
                        font: {
                            size: 10 // Adjust font size if necessary
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Households Distribution by Barangay',
                    font: {
                        size: 18
                    }
                }
            }
        }
    });
    </script>
</body>
</html>