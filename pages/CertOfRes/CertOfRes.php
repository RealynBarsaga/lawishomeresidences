<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header('Location: ../../login.php');
        exit;
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
        <?php include('../sidebar-left.php'); ?>

        <aside class="right-side">
            <section class="content-header">
                <h1>Certificate Of Residency</h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="box">
                        <div class="box-header">
                            <div style="padding:10px;">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> Add Certificate
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                </button>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <form method="post">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px !important;">
                                                <input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)" />
                                            </th>
                                            <th>Resident Name</th>
                                            <th>Purpose</th>
                                            <th>Purok</th>
                                            <th style="width: 300px !important;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $con->prepare("SELECT *, CONCAT(lname, ', ', fname, ' ', mname) AS resident, p.id AS pid
                                                               FROM tblrecidency p
                                                               LEFT JOIN tblresident r ON r.id = p.resident");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            echo '
                                            <tr>
                                                <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="'.$row['pid'].'" /></td>
                                                <td>'.$row['resident'].'</td>
                                                <td>'.$row['purpose'].'</td> 
                                                <td>'.$row['purok'].'</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-target="#editModal'.$row['pid'].'" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                    </button>
                                                </td>
                                            </tr>';
                                            include "edit_modal.php";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <?php include "../deleteModal.php"; ?>
                            </form>
                        </div>
                    </div>

                    <?php 
                    include "../edit_notif.php"; 
                    include "../added_notif.php"; 
                    include "../delete_notif.php"; 
                    include "../duplicate_error.php"; 
                    include "add_modal.php"; 
                    include "function.php"; 
                    ?>
                </div>
            </section>
        </aside>
    </div>

    <?php include "../footer.php"; ?>

    <script type="text/javascript">
        $(function() {
            $("#table").dataTable({
                "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 4] }],
                "aaSorting": []
            });
            $(".select2").select2();
        });
    </script>
</body>
</html>
