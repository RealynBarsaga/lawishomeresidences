<?php
if (isset($_POST['btn_add'])) {
    // Get form input values
    $txt_cnum = $_POST['txt_cnum'];
    $txt_name = $_POST['txt_name'];
    $txt_purpose = $_POST['txt_purpose'];
    $txt_ornum = $_POST['txt_ornum'];
    $txt_amount = $_POST['txt_amount'];
    $txt_age = $_POST['txt_age'];
    $txt_bdate = $_POST['txt_bdate'];
    $txt_purok = $_POST['txt_purok'];
    $date = date('Y-m-d');
    $off_barangay = $_SESSION["barangay"] ?? "";

    // Check for duplicate clearance
    $chkdup = mysqli_query($con, "SELECT * from tblclearance where name = '$txt_name'");
    $rows = mysqli_num_rows($chkdup);

    // Log the action if the session role is set
    if (isset($_SESSION['role'])) {
        $action = 'Added Clearance name of ' . $txt_name;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) values ('Brgy." . $_SESSION['staff'] . "', NOW(), '" . $action . "')");
    }

    // Insert clearance if no duplicates
    if ($rows == 0) {
        $query = mysqli_query($con, "INSERT INTO tblclearance 
            (clearanceNo, name, purpose, orNo, samount, dateRecorded, recordedBy, barangay, age, bdate, purok, report_type) 
            values ('$txt_cnum','$txt_name', '$txt_purpose', '$txt_ornum', '$txt_amount', '$date', '".$_SESSION['username']."', '$off_barangay', '$txt_age', '$txt_bdate', '$txt_purok', 'Clearance')") 
            or die('Error: ' . mysqli_error($con));

        // Handle successful insert
        if ($query == true) {
            $_SESSION['added'] = 1;
            header("location: " . $_SERVER['REQUEST_URI']);
            exit();
        }   
    } else {
        $_SESSION['duplicate'] = 1;
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}


if(isset($_POST['btn_req'])){
    $chkblot = mysqli_query($con,"select * from tblresident where '".$_SESSION['userid']."' not in (select complainant from tblblotter)");
    $num_row = mysqli_num_rows($chkblot);
    if($num_row > 0)
    {
        $chk = mysqli_query($con,"select * from tblresident where id = '".$_SESSION['userid']."' ");
        while($row = mysqli_fetch_array($chk)){

            if($row['lengthofstay'] < 6){
                $_SESSION['lengthofstay'] = 1;
                header ("location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
            else{
                $txt_purpose = $_POST['txt_purpose'];
                $date = date('Y-m-d');
                $reqquery = mysqli_query($con,"INSERT INTO tblclearance (clearanceNo,residentid,purpose,orNo,samount,dateRecorded,recordedBy,status) 
                    values ('','".$_SESSION['userid']."','','','$date','".$_SESSION['role']."','New') ")or die('Error: ' . mysqli_error($con));

                if($reqquery == true)
                {
                    header ("location: ".$_SERVER['REQUEST_URI']);
                    exit();
                } 
            }
        }
    } 
    else{
        $_SESSION['blotter'] = 1;
        header ("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_approve']))
{
    $txt_id = $_POST['hidden_id'];
    $txt_cnum = $_POST['txt_cnum'];
    $txt_findings = $_POST['txt_findings'];
    $txt_ornum = $_POST['txt_ornum'];
    $txt_amount = $_POST['txt_amount'];

    $approve_query = mysqli_query($con,"UPDATE tblclearance set clearanceNo= '".$txt_cnum."', findings = '".$txt_findings."', orNo = '".$txt_ornum."', samount = '".$txt_amount."', status='Approved' where id = '".$txt_id."' ") or die('Error: ' . mysqli_error($con));

    if($approve_query == true){
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_disapprove']))
{

    $txt_id = $_POST['hidden_id'];
    $txt_findings = $_POST['txt_findings'];
    $disapprove_query = mysqli_query($con,"UPDATE tblclearance set findings = '".$txt_findings."' , status='Disapproved' where id = '".$txt_id."' ") or die('Error: ' . mysqli_error($con));

    if($disapprove_query == true){
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_save'])) {
    $txt_edit_residentname = $_POST['txt_edit_residentname'];
    $txt_id = $_POST['hidden_id'];
    $txt_edit_cnum = $_POST['txt_edit_cnum'];
    $txt_edit_purpose = $_POST['txt_edit_purpose'];
    $txt_edit_ornum = $_POST['txt_edit_ornum'];
    $txt_edit_amount = $_POST['txt_edit_amount'];

    // New fields
    $txt_edit_age = $_POST['txt_edit_age'];
    $txt_edit_bdate = $_POST['txt_edit_bdate'];
    $txt_edit_purok = $_POST['txt_edit_purok'];

    // Update query including the new fields
    $update_query = mysqli_query($con,"UPDATE tblclearance SET 
    Name = '".$txt_edit_residentname."',
    clearanceNo = '".$txt_edit_cnum."', 
    purpose = '".$txt_edit_purpose."', 
    orNo = '".$txt_edit_ornum."', 
    samount = '".$txt_edit_amount."', 
    age = '".$txt_edit_age."', 
    bdate = '".$txt_edit_bdate."', 
    purok = '".$txt_edit_purok."' 
    WHERE id = '".$txt_id."' ") or die('Error: ' . mysqli_error($con));

    if(isset($_SESSION['role'])){
        $action = 'Update Clearance name of '.$txt_edit_residentname;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user, logdate, action) values ('Brgy.".$_SESSION['staff']."', NOW(), '".$action."')");
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
            $delete_query = mysqli_query($con,"DELETE from tblclearance where id = '$value' ") or die('Error: ' . mysqli_error($con));
                    
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