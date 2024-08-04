<?php
ob_start(); // Start output buffering

function redirect_with_session($key, $value) {
    $_SESSION[$key] = $value;
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if(isset($_POST['btn_add'])) {
    $ddl_resident = $_POST['ddl_resident'];
    $txt_busname = $_POST['txt_busname'];
    $txt_busadd = $_POST['txt_busadd'];
    $ddl_tob = $_POST['ddl_tob'];
    $txt_ornum = $_POST['txt_ornum'];
    $txt_amount = $_POST['txt_amount'];
    $date = date('Y-m-d H:i:s');

    $query = mysqli_query($con, "SELECT * FROM tblpermit WHERE id = $ddl_resident");
    $num_rows = mysqli_num_rows($query);

    if(isset($_SESSION['role'])) {
        $action = 'Added Permit with business name of ' . $txt_busname;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Administrator', NOW(), '$action')");
    }

    if($num_rows == 0) {
        $query = mysqli_query($con, "INSERT INTO tblpermit (Name, businessName, businessAddress, typeOfBusiness, orNo, samount, dateRecorded, recordedBy) 
            VALUES ('$ddl_resident', '$txt_busname', '$txt_busadd', '$ddl_tob', '$txt_ornum', '$txt_amount', '$date', '".$_SESSION['username']."')") or die('Error: ' . mysqli_error($con));
        if($query) {
            redirect_with_session('added', 1);
        }
    } else {
        redirect_with_session('duplicate', 1);
    }
}

if(isset($_POST['btn_req'])) {
    $txt_busname = $_POST['txt_busname'];
    $txt_busadd = $_POST['txt_busadd'];
    $ddl_tob = $_POST['ddl_tob'];
    $date = date('Y-m-d H:i:s');

    $reqquery = mysqli_query($con, "INSERT INTO tblpermit (residentid, businessName, businessAddress, typeOfBusiness, orNo, samount, dateRecorded, recordedBy, status) 
        VALUES ('".$_SESSION['userid']."', '$txt_busname', '$txt_busadd', '$ddl_tob', '', '', '$date', '".$_SESSION['username']."', 'New')") or die('Error: ' . mysqli_error($con));

    if($reqquery) {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_approve'])) {
    $txt_id = $_POST['hidden_id'];
    $txt_ornum = $_POST['txt_ornum'];
    $txt_amount = $_POST['txt_amount'];

    $approve_query = mysqli_query($con, "UPDATE tblpermit SET orNo = '$txt_ornum', samount = '$txt_amount', status = 'Approved' WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));

    if($approve_query) {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_disapprove'])) {
    $txt_id = $_POST['hidden_id'];

    $disapprove_query = mysqli_query($con, "UPDATE tblpermit SET status = 'Disapproved' WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));

    if($disapprove_query) {
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_save'])) {
    $txt_id = $_POST['hidden_id'];
    $txt_edit_busname = $_POST['txt_edit_busname'];
    $txt_edit_busadd = $_POST['txt_edit_busadd'];
    $ddl_edit_tob = $_POST['ddl_edit_tob'];
    $txt_edit_ornum = $_POST['txt_edit_ornum'];
    $txt_edit_amount = $_POST['txt_edit_amount'];

    $update_query = mysqli_query($con, "UPDATE tblpermit SET businessName = '$txt_edit_busname', businessAddress = '$txt_edit_busadd', typeOfBusiness = '$ddl_edit_tob', orNo = '$txt_edit_ornum', samount = '$txt_edit_amount' WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));

    if(isset($_SESSION['role'])) {
        $action = 'Update Permit with business name of ' . $txt_edit_busname;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Administrator', NOW(), '$action')");
    }

    if($update_query) {
        redirect_with_session('edited', 1);
    }
}

if(isset($_POST['btn_delete']) && isset($_POST['chk_delete'])) {
    foreach($_POST['chk_delete'] as $value) {
        $delete_query = mysqli_query($con, "DELETE FROM tblpermit WHERE id = '$value'") or die('Error: ' . mysqli_error($con));

        if($delete_query) {
            redirect_with_session('delete', 1);
        }
    }
}
ob_end_flush(); // Send the output buffer and turn off output buffering
?>
