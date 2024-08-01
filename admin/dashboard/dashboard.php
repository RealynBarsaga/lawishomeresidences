<!DOCTYPE html>
<html>
<?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header('Location: ../../admin/login.php');
        exit; // Ensure no further execution after redirect
    }
    include('../../admin/head_css.php'); // Removed ob_start() since it's not needed here
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

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <br>
                            <div class="info-box" style="margin-left: 9px; background-color: #00c0ef !important;">
                            <span style="background: transparent; position: absolute; top: 47%; left: 77%; transform: translate(-50%, -50%); font-size: 40px; color: #eeeeeeba; z-index: 1;">
                                <i class="fa fa-user"></i>
                            </span>
                                <span class="info-box-number" style="font-size: 30px; color: #fff; margin-left: 15px; font-family: 'Source Sans Pro', sans-serif; font-weight: bold;">
                                  <?php
                                    $q = mysqli_query($con, "SELECT * FROM tblofficial");
                                    $num_rows_officials = mysqli_num_rows($q);
                                    echo $num_rows_officials;
                                  ?>
                                  <span class="info-box-text">Madridejos Officials</span>
                                </span>
                                <div class="info-box-footer" style="margin-top: 35px; text-align: center; background-color: rgba(0, 0, 0, 0.1); padding: 5px; cursor: pointer;">
                                    <a href="../officials/officials.php" style="color: #fff; text-decoration: none; font-weight: 100; font-family: 'Source Sans Pro', sans-serif;">
                                        More Info <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <br>
                            <div class="info-box" style="margin-left: 10px; background-color: #007256 !important;">
                            <span style="background: transparent; position: absolute; top: 47%; left: 77%; transform: translate(-50%, -50%); font-size: 40px; color: #eeeeeeba; z-index: 1;">
                                <i class="fa fa-university"></i>
                            </span>
                                <span class="info-box-number" style="font-size: 30px; color: #fff; margin-left: 15px; font-family: 'Source Sans Pro', sans-serif; font-weight: bold;">
                                    <?php
                                      $q = mysqli_query($con, "SELECT * FROM tblstaff");
                                      $num_rows_staff = mysqli_num_rows($q);
                                      echo $num_rows_staff;
                                    ?>
                                    <span class="info-box-text">Total Barangay</span>
                                  </span>
                                  <div class="info-box-footer" style="margin-top: 35px; text-align: center; background-color: rgba(0, 0, 0, 0.1); padding: 5px; cursor: pointer;">
                                      <a href="../staff/staff.php" style="color: #fff; text-decoration: none; font-weight: 100; font-family: 'Source Sans Pro', sans-serif;">
                                        More Info <i class="fa fa-arrow-circle-right"></i>
                                      </a>
                                  </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <br>
                            <div class="info-box" style="margin-left: 12px; background-color: #bd1e24 !important;">
                            <span style="background: transparent; position: absolute; top: 47%; left: 77%; transform: translate(-50%, -50%); font-size: 40px; color: #eeeeeeba; z-index: 1;">
                                <i class="fa fa-file"></i>
                            </span>
                                  <span class="info-box-number" style="font-size: 30px; color: #fff; margin-left: 15px; font-family: 'Source Sans Pro', sans-serif; font-weight: bold;">
                                    <?php
                                      $q = mysqli_query($con, "SELECT * FROM tblpermit");
                                      $num_rows_permit = mysqli_num_rows($q);
                                      echo $num_rows_permit;
                                    ?>
                                    <span class="info-box-text">Total Permit</span>
                                  </span>
                                  <div class="info-box-footer" style="margin-top: 35px; text-align: center; background-color: rgba(0, 0, 0, 0.1); padding: 5px; cursor: pointer;">
                                      <a href="../permit/permit.php" style="color: #fff; text-decoration: none; font-weight: 100; font-family: 'Source Sans Pro', sans-serif;">
                                        More Info <i class="fa fa-arrow-circle-right"></i>
                                      </a>
                                  </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <br>
                            <div class="info-box" style="margin-left: 14px; background-color: #e5c707 !important;">
                            <span style="background: transparent; position: absolute; top: 47%; left: 77%; transform: translate(-50%, -50%); font-size: 40px; color: #eeeeeeba; z-index: 1;">
                                <i class="fa fa-users"></i>
                            </span>
                                  <span class="info-box-number" style="font-size: 30px; color: #fff; margin-left: 15px; font-family: 'Source Sans Pro', sans-serif; font-weight: bold;">
                                    <?php
                                      $q = mysqli_query($con, "SELECT * FROM tblhousehold");
                                      $num_rows_household = mysqli_num_rows($q);
                                      echo $num_rows_household;
                                    ?>
                                    <span class="info-box-text">Total Household</span>
                                  </span>
                                  <div class="info-box-footer" style="margin-top: 35px; text-align: center; background-color: rgba(0, 0, 0, 0.1); padding: 5px; cursor: pointer;">
                                      <a href="../householdlist/householdlist.php" style="color: #fff; text-decoration: none; font-weight: 100; font-family: 'Source Sans Pro', sans-serif;">
                                        More Info <i class="fa fa-arrow-circle-right"></i>
                                      </a>
                                  </div>
                            </div>
                        </div>

                    </div><!-- /.box -->

                    <div class="col-md-12">
                        <canvas id="myBarChart" width="100" height="30" style="max-width: 35%;background: #fff;"></canvas>
                    </div>

                </div><!-- /.row -->

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <script>
        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Officials', 'Barangay', 'Permits', 'Households'],
                datasets: [{
                    label: 'Count',
                    data: [
                        <?php echo $num_rows_officials; ?>,
                        <?php echo $num_rows_staff; ?>,
                        <?php echo $num_rows_permit; ?>,
                        <?php echo $num_rows_household; ?>
                    ],
                    backgroundColor: [
                        'rgba(0, 192, 239, 0.6)',
                        'rgba(0, 115, 86, 0.6)',
                        'rgba(189, 30, 36, 0.6)',
                        'rgba(229, 199, 7, 0.6)'
                    ],
                    borderColor: [
                        'rgba(0, 192, 239, 1)',
                        'rgba(0, 115, 86, 1)',
                        'rgba(189, 30, 36, 1)',
                        'rgba(229, 199, 7, 1)'
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

    <?php  include "../../admin/footer.php"; ?>
</body>
</html>