<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header('Location: ../../login.php');
        exit; // Ensure no further execution after redirect
    }
    include('../head_css.php');
?>
<head>
    <!-- Include Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="skin-black">
    <?php 
      include "../connection.php"; 
      include('../header.php'); 
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
            width: 80%;
            margin: auto;
        }
    </style>

    <div class="wrapper row-offcanvas row-offcanvas-left">
    <?php include('../sidebar-left.php'); ?>

        <aside class="right-side">
            <section class="content-header">
                <h1>Dashboard</h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="box">
                        <!-- Info Boxes -->
                        <?php
                        $off_barangay = $_SESSION['barangay'];
                        $info_boxes = [
                            ['label' => 'Barangay Officials', 'icon' => 'fa-user', 'color' => '#00c0ef', 'query' => "SELECT * FROM tblbrgyofficial WHERE barangay = '$off_barangay'", 'link' => '../officials/officials.php'],
                            ['label' => 'Total Household', 'icon' => 'fa-users', 'color' => '#007256', 'query' => "SELECT * FROM tblhousehold h 
                                    LEFT JOIN tbltabagak r ON r.id = h.headoffamily WHERE r.barangay = '$off_barangay'", 'link' => '../household/household.php?page=household'],
                            ['label' => 'Total Resident', 'icon' => 'fa-users', 'color' => '#bd1e24', 'query' => "SELECT * FROM tbltabagak WHERE barangay = '$off_barangay'", 'link' => '../resident/resident.php?page=resident'],
                            ['label' => 'Total Clearance', 'icon' => 'fa-file', 'color' => '#e5c707', 'query' => "SELECT * FROM tblclearance WHERE barangay = '$off_barangay'", 'link' => '../BrgyClearance/BrgyClearance.php?page=BrgyClearance']
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
                                <div class="info-box-footer" style="margin-top: 35px; text-align: center; background-color: rgba(0, 0, 0, 0.1); padding: 5px; pointer; z-index: 999; cursor: pointer;">
                                    <a href="<?= $box['link'] ?>" style="color: #fff; text-decoration: none; font-weight: 100; font-family: 'Source Sans Pro', sans-serif;">
                                        More Info <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div><!-- /.box -->
                    <!-- Bar Chart -->
                    <!-- <div class="col-md-12">
                        <canvas id="myBarChart" width="100" height="30" style="max-width: 35%;background: #fff;"></canvas>
                    </div> -->
                        <?php
                        // Query to count data for each barangay
                        $barangays = ['Tabagak', 'Bunakan', 'Kodia', 'Talangnan', 'Maalat', 'Pili', 'Kaongkod', 'Mancilang', 'Kangwayan', 'Tugas', 'Malbago', 'Tarong', 'San Agustin'];
                        $counts = [];
                    
                        foreach ($barangays as $barangay) {
                            $q = mysqli_query($con, "SELECT * FROM tbltabagak WHERE barangay = '$barangay'");
                            $counts[] = mysqli_num_rows($q);
                        }
                        ?>
                        <script>
                            const ctx = document.getElementById('myBarChart').getContext('2d');
                            const myBarChart = new Chart(ctx, {
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
                        </script>
                </div><!-- /.row -->
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->    
    <?php include "../footer.php"; ?>
</body>
</html>
