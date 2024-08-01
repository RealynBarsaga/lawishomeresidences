<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header('Location: ../../login.php');
        exit; // Ensure no further execution after redirect
    }
    include('../head_css.php'); // Removed ob_start() since it's not needed here
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
                <h1>Barangay Clearance</h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="box">
                        <div class="box-header">
                            <div style="padding:10px;">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> Add Clearance
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                </button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
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
                                                    <th>Clearance #</th>
                                                    <th>Purpose</th>
                                                    <th>OR Number</th>
                                                    <th>Amount</th>
                                                    <th style="width: 15% !important;">Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Fetch approved clearances from database
                                                $squery = mysqli_query($con, "SELECT *, CONCAT(r.lname, ', ', r.fname, ' ', r.mname) AS residentname, p.id AS pid FROM tblclearance p LEFT JOIN tblresident r ON r.id = p.residentid") or die('Error: ' . mysqli_error($con));

                                                while ($row = mysqli_fetch_array($squery)) {
                                                    echo '
                                                        <tr>
                                                            <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . htmlspecialchars($row['pid']) . '" /></td>
                                                            <td>' . htmlspecialchars($row['residentname']) . '</td>
                                                            <td>' . htmlspecialchars($row['clearanceNo']) . '</td>
                                                            <td>' . htmlspecialchars($row['purpose']) . '</td>
                                                            <td>' . htmlspecialchars($row['orNo']) . '</td>
                                                            <td>₱ ' . number_format($row['samount'], 2) . '</td>
                                                            <td style="width: 170px;">
                                                                <button class="btn btn-primary btn-sm" data-target="#editModal' . htmlspecialchars($row['pid']) . '" data-toggle="modal">
                                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                                </button>
                                                                <!-- Link to generate clearance form -->
                                                                <a style="width: 80px;" target="_blank" href="BrgyClearance_form.php?resident=' . urlencode($row['residentid']) . '&purpose=' . urlencode($row['purpose']) . '&clearance=' . urlencode($row['clearanceNo']) . '&val=' . urlencode(base64_encode($row['clearanceNo'] . '|' . $row['residentname'] . '|' . $row['dateRecorded'])) . '" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Generate
                                                                </a>
                                                            </td>
                                                        </tr>';
                                                    include "edit_modal.php"; // Include edit modal for each row
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

    <script type="text/javascript">
        $(function() {
            $("#table").dataTable({
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 6]
                }],
                "aaSorting": []
            });
        });
    </script>
</body>
</html>
