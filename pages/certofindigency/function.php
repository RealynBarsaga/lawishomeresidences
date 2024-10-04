<?php
if(isset($_POST['btn_add'])){
    // Sanitize inputs
    $txt_name = htmlspecialchars(stripslashes(trim($_POST['txt_name'])), ENT_QUOTES, 'UTF-8');
    $txt_prps = htmlspecialchars(stripslashes(trim($_POST['txt_prps'])), ENT_QUOTES, 'UTF-8');
    $txt_purok = htmlspecialchars(stripslashes(trim($_POST['txt_purok'])), ENT_QUOTES, 'UTF-8');
    $date = date('Y-m-d'); // Current date
    
    // Basic Validation
    if (empty($txt_name) || empty($txt_prps) || empty($txt_purok)) {
        die('Required fields are missing.');
    }
    
    // Validate name (letters and spaces allowed)
    if (!preg_match('/^[a-zA-Z\s]+$/', $txt_name)) {
        die('Invalid name format. Only letters and spaces are allowed.');
    }
    
    // Validate purpose (allowing alphanumeric characters, spaces, and basic punctuation)
    if (!preg_match('/^[a-zA-Z0-9\s,.!?]+$/', $txt_prps)) {
        die('Invalid purpose format. Only alphanumeric characters and basic punctuation are allowed.');
    }
    
    // Validate purok (assuming it's numeric)
    if (!preg_match('/^[0-9]+$/', $txt_purok)) {
        die('Invalid purok. Only numbers are allowed.');
    }

    $chkdup = mysqli_query($con,"SELECT * from tblindigency where name = '$txt_name'");
    $rows = mysqli_num_rows($chkdup);

    if(isset($_SESSION['role'])){
        $action = 'Added certificate of residency named of '.$txt_name;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('Brgy.".$_SESSION['staff']."', NOW(), '".$action."')");
    }

    if($rows == 0){
        $query = mysqli_query($con,"INSERT INTO tblindigency (Name, purpose, purok, barangay, dateRecorded, report_type) 
            values ('$txt_name', '$txt_prps', '$txt_purok', '$off_barangay', '$date', 'Certificate Of Indigency') ") or die('Error: ' . mysqli_error($con));
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
    // Sanitize inputs
    $txt_edit_resident = htmlspecialchars(stripslashes(trim($_POST['txt_edit_resident'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_purpose = htmlspecialchars(stripslashes(trim($_POST['txt_edit_purpose'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_purok = htmlspecialchars(stripslashes(trim($_POST['txt_edit_purok'])), ENT_QUOTES, 'UTF-8');
    
    // Basic Validation
    if (empty($txt_edit_resident) || empty($txt_edit_purpose) || empty($txt_edit_purok)) {
        die('Required fields are missing.');
    }
    
    // Validate resident name (letters and spaces allowed)
    if (!preg_match('/^[a-zA-Z\s]+$/', $txt_edit_resident)) {
        die('Invalid resident name format. Only letters and spaces are allowed.');
    }
    
    // Validate purpose (allowing alphanumeric characters, spaces, and basic punctuation)
    if (!preg_match('/^[a-zA-Z0-9\s,.!?]+$/', $txt_edit_purpose)) {
        die('Invalid purpose format. Only alphanumeric characters and basic punctuation are allowed.');
    }
    
    // Validate purok (assuming it's numeric)
    if (!preg_match('/^[0-9]+$/', $txt_edit_purok)) {
        die('Invalid purok. Only numbers are allowed.');
    }

    $update_query = mysqli_query($con,"UPDATE tblindigency set purpose = '".$txt_edit_purpose."', purok = '".$txt_edit_purok."' ") or die('Error: ' . mysqli_error($con));

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
            $delete_query = mysqli_query($con,"DELETE from tblindigency where id = '$value' ") or die('Error: ' . mysqli_error($con));
                    
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