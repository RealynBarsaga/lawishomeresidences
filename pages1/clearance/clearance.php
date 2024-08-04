<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    if(!isset($_SESSION['role'])) {
        header("Location: ../../login.php");
        exit(); // Redirect to login if session role is not set
    } else {
        ob_start();
        include('../head_css.php'); // Include CSS specific to this page
    }
    ?>
    <style>
        .nav-tabs li a {
            cursor: pointer; /* Style for navigation tabs */
        }
    </style>
</head>

<body class="skin-black">
    <?php include "../connection.php"; ?> <!-- Include database connection -->
    <?php include('../header.php'); ?> <!-- Include header -->

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include('../sidebar-left.php'); ?> <!-- Include left sidebar -->

        <aside class="right-side">
            <section class="content-header">
                <h1>Clearance</h1> <!-- Page title -->
            </section>

            <section class="content">
                <div class="box">
                    <div class="box-header">
                        <div style="padding:10px;">
                            <!-- Buttons to add and delete clearance -->
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Add Clearance
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                            </button>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive">
                        <ul class="nav nav-tabs" id="myTab">
                            <!-- Navigation tabs for approved and disapproved clearances -->
                            <li class="active"><a data-target="#approved" data-toggle="tab">Approved</a></li>
                            <li><a data-target="#disapproved" data-toggle="tab">Disapproved</a></li>
                        </ul>

                        <div class="tab-content">
                            <!-- Tab content for approved clearances -->
                            <div id="approved" class="tab-pane active in">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)"/></th>
                                            <th>Clearance #</th>
                                            <th>Resident Name</th>
                                            <th>Findings</th>
                                            <th>Purpose</th>
                                            <th>OR Number</th>
                                            <th>Amount</th>
                                            <th style="width: 15% !important;">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch approved clearances from database
                                        $squery = mysqli_query($con, "SELECT *, CONCAT(r.lname, ', ' ,r.fname, ' ' ,r.mname) as residentname, p.id as pid FROM tblclearance p left join tblresident r on r.id = p.residentid where status = 'Approved'") or die('Error: ' . mysqli_error($con));
                                        while ($row = mysqli_fetch_array($squery)) {
                                            echo'
                                            <tr>
                                                <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="'.$row['pid'].'" /></td>
                                                <td>'.$row['clearanceNo'].'</td>
                                                <td>'.$row['residentname'].'</td>
                                                <td>'.$row['findings'].'</td>
                                                <td>'.$row['purpose'].'</td>
                                                <td>'.$row['orNo'].'</td>
                                                <td>₱ '.number_format($row['samount'], 2).'</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-target="#editModal '.$row['pid'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
                                                    <!-- Link to generate clearance form -->
                                                    <a target="_blank" href="clearance_form.php?resident= '.$row['residentid'].' &clearance= '.$row['clearanceNo'].' &val= '.base64_encode($row['clearanceNo'] . '|' . $row['residentname'] . '|' . $row['dateRecorded']).'" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Generate</a>
                                                </td>
                                            </tr>';
                                            include "edit_modal.php"; // Include edit modal for each row
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tab content for disapproved clearances -->
                            <div id="disapproved" class="tab-pane">
                                <table id="table1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)"/></th>
                                            <th>Resident Name</th>
                                            <th>Findings</th>
                                            <th>Purpose</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch disapproved clearances from database
                                        $squery = mysqli_query($con, "SELECT *, CONCAT(r.lname, ', ' ,r.fname, ' ' ,r.mname) as residentname, p.id as pid FROM tblclearance p left join tblresident r on r.id = p.residentid where status = 'Disapproved'") or die('Error: ' . mysqli_error($con));
                                        while ($row = mysqli_fetch_array($squery)) {
                                            echo '
                                            <tr>
                                                <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="'.$row['pid'].'" /></td>
                                                <td>'.$row['residentname'].'</td>
                                                <td>'.$row['findings'].'</td>
                                                <td>'.$row['purpose'].'</td>
                                            </tr>';
                                            include "edit_modal.php"; // Include edit modal for each row
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <?php include "../deleteModal.php"; ?> <!-- Include delete modal -->
                <?php include "../edit_notif.php"; ?> <!-- Include edit notification -->
                <?php include "../added_notif.php"; ?> <!-- Include added notification -->
                <?php include "../delete_notif.php"; ?> <!-- Include delete notification -->
                <?php include "../duplicate_error.php"; ?> <!-- Include duplicate error notification -->
                <?php include "add_modal.php"; ?> <!-- Include add modal -->
                <?php include "function.php"; ?> <!-- Include functions -->

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- /.wrapper -->

    <?php include "../footer.php"; ?> <!-- Include footer -->
</body>
</html>
