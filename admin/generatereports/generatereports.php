<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header('Location: ../../admin/login.php');
        exit; // Ensure no further execution after redirect
    }
    include('../../admin/head_css.php');
    include("../connection.php");
    ?>
</head>

<body class="skin-black">
    <!-- header logo: style can be found in header.less -->
    <?php include('../header.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('../sidebar-left.php'); ?>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Generated Reports</h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="box">
                        <div class="box-header">
                            <div style="padding:10px;">
                                <!-- Optional content for the box header -->
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post">
                                <table id="table" class="table table-bordered table-striped">
                                <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Resident Name</th>
                                            <th>Date</th>
                                            <th>Barangay</th>
                                            <th>Report Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Ensure you have the correct database connection
                                        $squery = mysqli_query($con, "
                                            (SELECT id, name, dateRecorded, barangay, report_type FROM tblclearance)
                                            UNION
                                            (SELECT id, name, dateRecorded, barangay, report_type FROM tblrecidency)
                                            UNION
                                            (SELECT id, name, dateRecorded, barangay, report_type FROM tblindigency)
                                        ");
                                        
                                        // Check for query errors
                                        if (!$squery) {
                                            die('MySQL Error: ' . mysqli_error($con));
                                        }
                                        
                                        // Fetch and display rows from the result set
                                        while ($row = mysqli_fetch_array($squery, MYSQLI_ASSOC)) {
                                            echo '
                                            <tr>
                                                <td>'.$row['id'].'</td>
                                                <td>'.$row['name'].'</td>
                                                <td>'.$row['dateRecorded'].'</td>
                                                <td>'.$row['barangay'].'</td>
                                                <td>'.$row['report_type'].'</td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <!-- jQuery 2.0.2 -->
    <?php include("../footer.php"); ?>
    <script type="text/javascript">
        $(function() {
            $("#table").dataTable({
                "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
                "aaSorting": []
            });
        });
    </script>
</body>
</html>
