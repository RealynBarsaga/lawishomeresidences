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
    include('../../admin/head_css.php'); // Removed ob_start() since it's not needed here
    ?>
    <style>
        .nav-tabs li a {
            cursor: pointer;
        }
    </style>
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
                <h1>Business Permit</h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="box">
                        <div class="box-header">
                            <div style="padding:10px;">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> Add Permit
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                </button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <!-- <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a data-target="#approved" data-toggle="tab">Approved</a></li>
                                <li><a data-target="#disapproved" data-toggle="tab">Disapproved</a></li>
                            </ul> -->
                            <form method="post">
                                <div class="tab-content">
                                    <div id="approved" class="tab-pane active in">
                                        <table id="table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px !important;">
                                                        <input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)"/>
                                                    </th>
                                                    <th>Resident Name</th>
                                                    <th>Business Name</th>
                                                    <th>Business Address</th>
                                                    <th>Type of Business</th>
                                                    <th>OR Number</th>
                                                    <th>Amount</th>
                                                    <th style="width: 40px !important;">Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $squery = mysqli_query($con, "SELECT *, CONCAT(r.lname, ', ', r.fname, ' ', r.mname) AS residentname, p.id AS pid FROM tblpermit p LEFT JOIN tblresident r ON r.id = p.residentid") or die('Error: ' . mysqli_error($con));
                                                while ($row = mysqli_fetch_array($squery)) {
                                                    echo '
                                                    <tr>
                                                        <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . htmlspecialchars($row['pid']) . '" /></td>
                                                        <td>' . htmlspecialchars($row['residentname']) . '</td>
                                                        <td>' . htmlspecialchars($row['businessName']) . '</td>
                                                        <td>' . htmlspecialchars($row['businessAddress']) . '</td>
                                                        <td>' . htmlspecialchars($row['typeOfBusiness']) . '</td>
                                                        <td>' . htmlspecialchars($row['orNo']) . '</td>
                                                        <td>₱ ' . number_format($row['samount'], 2) . '</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm" data-target="#editModal' . $row['pid'] . '" data-toggle="modal">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    ';
                                                    include "edit_modal.php";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <?php include "../deleteModal.php"; ?>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <?php include "../edit_notif.php"; ?>
                    <?php include "../added_notif.php"; ?>
                    <?php include "../delete_notif.php"; ?>
                    <?php include "../duplicate_error.php"; ?>
                    <?php include "add_modal.php"; ?>
                    <?php include "function.php"; ?>
                </div><!-- /.row -->
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <?php include "../footer.php"; ?>

    <!-- DataTables script -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <script type="text/javascript">
        $(document).ready(function() {
            $("#table").DataTable({
                "columnDefs": [
                    { "sortable": false, "targets": [0, 6] }
                ],
                "order": []
            });
        });
    </script>
</body>
</html>
