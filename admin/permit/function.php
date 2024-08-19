<?php
if(isset($_POST['btn_add'])){
    $txt_name = mysqli_real_escape_string($con, $_POST['txt_name']);
    $txt_busname = mysqli_real_escape_string($con, $_POST['txt_busname']);
    $txt_busadd = mysqli_real_escape_string($con, $_POST['txt_busadd']);
    $ddl_tob = mysqli_real_escape_string($con, $_POST['ddl_tob']);
    $txt_ornum = mysqli_real_escape_string($con, $_POST['txt_ornum']);
    $txt_amount = mysqli_real_escape_string($con, $_POST['txt_amount']);
    $date = date('Y-m-d H:i:s');

    $query = mysqli_query($con, "SELECT * FROM tblpermit WHERE name = '$txt_name'");
    $num_rows = mysqli_num_rows($query);

    if(isset($_SESSION['role'])){
        $action = 'Added Permit with name of '.$txt_name;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Administrator', NOW(), '$action')");
    }

    if($num_rows == 0){
        $query = mysqli_query($con, "INSERT INTO tblpermit (name, businessName, businessAddress, typeOfBusiness, orNo, samount, dateRecorded, recordedBy) 
        VALUES ('$txt_name', '$txt_busname', '$txt_busadd', '$ddl_tob', '$txt_ornum', '$txt_amount', '$date', '".$_SESSION['username']."')") or die('Error: ' . mysqli_error($con));
        if($query == true){
            $_SESSION['added'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
            exit();
        }
    } else {
        $_SESSION['duplicate'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit(); // Ensure no further code is executed after redirection
    }
}
if(isset($_POST['btn_req'])){
    $txt_busname = $_POST['txt_busname'];
    $txt_busadd = $_POST['txt_busadd'];
    $ddl_tob = $_POST['ddl_tob'];
    $date = date('Y-m-d H:i:s');

    $reqquery = mysqli_query($con,"INSERT INTO tblpermit (residentid,businessName,businessAddress,typeOfBusiness,orNo,samount,dateRecorded,recordedBy,status) 
        values ('".$_SESSION['userid']."', '$txt_busname', '$txt_busadd', '$ddl_tob', '', '', '$date', '".$_SESSION['username']."','New')") or die('Error: ' . mysqli_error($con));

    if($reqquery == true){
        header ("location: ".$_SERVER['REQUEST_URI']);
        exit(); // Ensure no further code is executed after redirection
    }   
}
if(isset($_POST['btn_approve'])){
    $txt_id = $_POST['hidden_id'];
    $txt_ornum = $_POST['txt_ornum'];
    $txt_amount = $_POST['txt_amount'];

    $approve_query = mysqli_query($con,"UPDATE tblpermit set orNo = '".$txt_ornum."', samount = '".$txt_amount."',status = 'Approved'  where id = '".$txt_id."' ") or die('Error: ' . mysqli_error($con));

    if($approve_query == true){
        header("location: ".$_SERVER['REQUEST_URI']);
        exit(); // Ensure no further code is executed after redirection
    }
}

if(isset($_POST['btn_disapprove'])){
    $txt_id = $_POST['hidden_id'];

    $disapprove_query = mysqli_query($con,"UPDATE tblpermit set status = 'Disapproved'  where id = '".$txt_id."' ") or die('Error: ' . mysqli_error($con));

    if($disapprove_query == true){
        header("location: ".$_SERVER['REQUEST_URI']);
        exit(); // Ensure no further code is executed after redirection
    }
}
if(isset($_POST['btn_save'])){
    $txt_id = $_POST['hidden_id'];
    $txt_edit_name = $_POST['txt_edit_name'];
    $txt_edit_busname = $_POST['txt_edit_busname'];
    $txt_edit_busadd = $_POST['txt_edit_busadd'];
    $ddl_edit_tob = $_POST['ddl_edit_tob'];
    $txt_edit_ornum = $_POST['txt_edit_ornum'];
    $txt_edit_amount = $_POST['txt_edit_amount'];

    $update_query = mysqli_query($con,"UPDATE tblpermit set name = '".$txt_edit_name."', businessName = '".$txt_edit_busname."', businessAddress = '".$txt_edit_busadd."', typeOfBusiness= '".$ddl_edit_tob."', orNo = '".$txt_edit_ornum."', samount = '".$txt_edit_amount."'  where id = '".$txt_id."' ") or die('Error: ' . mysqli_error($con));

    if(isset($_SESSION['role'])){
        $action = 'Update Permit with name of '.$txt_edit_name;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('Administrator', NOW(), '".$action."')");
    }

    if($update_query == true){
        $_SESSION['edited'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit(); // Ensure no further code is executed after redirection
    }
}
if(isset($_POST['btn_delete'])){
    if(isset($_POST['chk_delete'])){
        foreach($_POST['chk_delete'] as $id){
            $delete_query = mysqli_query($con,"DELETE FROM tblpermit WHERE `tblpermit`.`id` = $id") or die('Error: ' . mysqli_error($con));

            if($delete_query == true){
                $_SESSION['delete'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
                exit(); // Ensure no further code is executed after redirection
            }
        }
    }
}
?>
