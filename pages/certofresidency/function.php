<?php
if(isset($_POST['btn_add'])){
    $txt_name = $_POST['txt_name'];
    $txt_prps = $_POST['txt_prps'];
    $txt_purok = $_POST['txt_purok'];
    $date = date('Y-m-d');


    $chkdup = mysqli_query($con,"SELECT * from tblrecidency where name = '$txt_name'");
    $rows = mysqli_num_rows($chkdup);

    if(isset($_SESSION['role'])){
        $action = 'Added certificate of residency named of '.$txt_name;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('Brgy.".$_SESSION['staff']."', NOW(), '".$action."')");
    }

    if($rows == 0){
        $query = mysqli_query($con,"INSERT INTO tblrecidency (Name, purpose, purok, barangay, dateRecorded, report_type) 
            values ('$txt_name', '$txt_prps', '$txt_purok', '$off_barangay', '$date', 'Certificate Of Residency') ") or die('Error: ' . mysqli_error($con));
        if($query == true)
        {
            $_SESSION['added'] = 1;
            header ("location: ".$_SERVER['REQUEST_URI']);
            exit();
        }   
    }
    else{
        $_SESSION['duplicate'] = 1;
        header ("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_save']))
{
    $txt_edit_resident = $_POST['txt_edit_resident'];
    $txt_edit_purpose = $_POST['txt_edit_purpose'];
    $txt_edit_purok = $_POST['txt_edit_purok'];


    $update_query = mysqli_query($con,"UPDATE tblrecidency set purpose = '".$txt_edit_purpose."', purok = '".$txt_edit_purok."' ") or die('Error: ' . mysqli_error($con));

    if(isset($_SESSION['role'])){
        $action = 'Update Certificate Of Recidency named of '.$txt_edit_resident;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('Brgy.".$_SESSION['staff']."', NOW(), '".$action."')");
    }

    if($update_query == true){
        $_SESSION['edited'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_delete']))
{
    if(isset($_POST['chk_delete']))
    {
        foreach($_POST['chk_delete'] as $value)
        {
            $delete_query = mysqli_query($con,"DELETE from tblrecidency where id = '$value' ") or die('Error: ' . mysqli_error($con));
                    
            if($delete_query == true)
            {
                $_SESSION['delete'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
        }
    }
}
?>