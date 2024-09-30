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
                <h1>Certificate Of Indigency</h1>
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
                                            <th style="width: 100px; text-align: left;">
                                                <label>
                                                    <input type="checkbox" class="cbxMain" onchange="checkMain(this)" style="vertical-align: middle;" />
                                                    <span style="vertical-align: -webkit-baseline-middle; margin-left: 5px; font-size: 13px;">Select All</span>
                                                </label>
                                            </th>
                                            <th>Resident Name</th>
                                            <th>Purpose</th>
                                            <th>Purok</th>
                                            <th style="width: 160.667px;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $con->prepare("SELECT Name, purpose, purok, id AS pid FROM tblindigency WHERE barangay = '$off_barangay'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            echo '
                                            <tr>
                                                <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="'.$row['pid'].'" /></td>
                                                <td>'.$row['Name'].'</td>
                                                <td>'.$row['purpose'].'</td> 
                                                <td>'.$row['purok'].'</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-target="#editModal'.$row['pid'].'" data-toggle="modal">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                    </button>
                                                    <a style="width: 80px;" href="certofres_form.php?" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-print" aria-hidden="true"></i> Print
                                                    </a>
                                                </td>
                                            </tr>'; /*  &resident=' . urlencode($row['name']) . '&purpose=' . urlencode($row['purpose']) . '&clearance=' . urlencode($row['clearanceNo']) . '&val=' . urlencode(base64_encode($row['clearanceNo'] . '|' . $row['name'])) . '  */
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
/* function printRow(id) {
    // This will fetch the specific row using the ID
    var printContents = document.querySelector("tr input[value='"+id+"']").closest('tr').outerHTML;
    
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = '<table>' + printContents + '</table>';

    window.print();

    document.body.innerHTML = originalContents;
} */
    </script>
</body>
</html>
