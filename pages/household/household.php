<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header('Location: ../../login.php');
        exit; // Ensure no further execution after redirect
    }
    include('../head_css.php');
    ?>
</head>

<body class="skin-black">
    <?php 
    include "../connection.php"; 
    include('../header.php'); 
    ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column contains the logo and sidebar -->
        <?php include('../sidebar-left.php'); ?>

        <!-- Right side column contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Household</h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- Box container -->
                    <div class="box">
                        <div class="box-header">
                            <div style="padding:10px;">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> Add Household
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                </button>
                            </div>
                        </div><!-- /.box-header -->

                        <div class="box-body table-responsive">
                            <form method="post">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px; text-align: left;">
                                                <label>
                                                    <input type="checkbox" class="cbxMain" onchange="checkMain(this)" style="vertical-align: middle;" />
                                                    <span style="vertical-align: -webkit-baseline-middle; margin-left: 5px; font-size: 13px;">Select All</span>
                                                </label>
                                            </th>
                                            <th>Household #</th>
                                            <th>Total Members</th>
                                            <th>Head of Family</th>
                                            <th>Barangay</th>
                                            <th>Purok</th>
                                            <th style="width: 40px !important;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    // Use prepared statements to prevent SQL injection
                                    $stmt = $con->prepare("SELECT *, h.id as id, CONCAT(r.lname, ', ', r.fname, ' ', r.mname) as name 
                                    FROM tblhousehold h 
                                    LEFT JOIN tbltabagak r ON r.id = h.headoffamily WHERE r.barangay = '$off_barangay'");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Fetch and display the results
                                    while ($row = $result->fetch_assoc()) {
                                        echo '
                                        <tr>
                                            <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . htmlspecialchars($row['id']) . '" /></td>
                                            <td><a href="../resident/resident.php?resident=' . htmlspecialchars($row['householdno']) . '">' . htmlspecialchars($row['householdno']) . '</a></td>
                                            <td>' . htmlspecialchars($row['totalhousehold']) . '</td>
                                            <td>' . htmlspecialchars($row['name']) . '</td>
                                            <td>' . htmlspecialchars($row['barangay']) . '</td>
                                            <td>' . htmlspecialchars($row['purok']) . '</td>
                                            <td><button class="btn btn-primary btn-sm" data-target="#editModal' . htmlspecialchars($row['id']) . '" data-toggle="modal">
                                                <i class="fa fa-eye" aria-hidden="true"></i> View
                                                </button></td>
                                        </tr>';

                                        include "edit_modal.php";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php include "../deleteModal.php"; ?>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <!-- Include notifications and modals -->
                    <?php 
                    include "../edit_notif.php"; 
                    include "../added_notif.php"; 
                    include "../delete_notif.php"; 
                    include "../duplicate_error.php"; 
                    include "add_modal.php"; 
                    include "function.php"; 
                    ?>
                </div> <!-- /.row -->
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <!-- jQuery 2.0.2 -->
    <?php include "../footer.php"; ?>

    <script type="text/javascript">
        $(function() {
            $("#table").dataTable({
                "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 5] }],
                "aaSorting": []
            });
            $(".select2").select2();
        });
    </script>
</body>
</html>