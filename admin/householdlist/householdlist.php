<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <?php
        session_start();
        if (!isset($_SESSION['userid'])) {
            header('Location: ../../admin/login.php');
            exit; // Ensure no further execution after redirect
        }
        include('../../admin/head_css.php');
    ?>
</head>
<body class="skin-black">
    <!-- header logo: style can be found in header.less -->
    <?php 
        include "../connection.php";
        include('../header.php'); 
    ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('../sidebar-left.php'); ?>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Total Household</h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="box">
                        <div class="box-header">
                            <div style="padding:10px;"></div>                                
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <form method="post">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Household #</th>
                                            <th>Head Of Family</th>
                                            <th>Total Members</th>
                                            <th>Barangay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Prepared statement for security
                                            $stmt = $con->prepare("
                                                SELECT h.id, h.householdno, r.lname, r.fname, r.mname, h.totalhousehold, b.barangay
                                                FROM tblhousehold h
                                                LEFT JOIN tblresident r ON r.id = h.headoffamily
                                                LEFT JOIN tblresident b ON r.id = b.id
                                            ");
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            while ($row = $result->fetch_assoc()) {
                                                $name = "{$row['lname']}, {$row['fname']} {$row['mname']}";
                                                echo '
                                                <tr>
                                                    <td>'.$row['id'].'</td>
                                                    <td><a href="../resident/resident.php?resident=' . htmlspecialchars($row['householdno']) . '">' . htmlspecialchars($row['householdno']) . '</a></td>
                                                    <td>' . htmlspecialchars($name) . '</td>
                                                    <td>' . htmlspecialchars($row['totalhousehold']) . '</td>
                                                    <td>' . htmlspecialchars($row['barangay']) . '</td>
                                                </tr>';
                                            }
                                            $stmt->close();
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
    <?php include "../footer.php"; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#table").DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [0] }
                ],
                "order": []
            });
        });
    </script>
</body>
</html>
