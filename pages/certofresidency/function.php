<?php
if(isset($_POST['btn_add'])){
    // Set Content Security Policy
    header("Content-Security-Policy: script-src 'self';");
    
    // Sanitize inputs
    $txt_name = htmlspecialchars(stripslashes(trim($_POST['txt_name'])), ENT_QUOTES, 'UTF-8');
    $txt_prps = htmlspecialchars(stripslashes(trim($_POST['txt_prps'])), ENT_QUOTES, 'UTF-8');
    $txt_purok = htmlspecialchars(stripslashes(trim($_POST['txt_purok'])), ENT_QUOTES, 'UTF-8');
    $date = date('Y-m-d'); // Current date in 'YYYY-MM-DD' format
    
    // Basic Validation
    if (empty($txt_name) || empty($txt_prps) || empty($txt_purok)) {
        die('Required fields are missing.');
    }
    
    // Optional: Validate name (ensure it contains only letters and spaces)
    if (!preg_match('/^[a-zA-Z\s]+$/', $txt_name)) {
        die('Invalid name format. Only letters and spaces are allowed.');
    }
    
    // Optional: Validate purok (if it needs to follow specific formats, such as numeric or alphanumeric, customize the regex)
    // Example: Ensure purok is numeric (modify if different rules apply)
    if (!preg_match('/^[0-9]+$/', $txt_purok)) {
        die('Invalid purok. Only numbers are allowed.');
    }

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
    // Set Content Security Policy
    header("Content-Security-Policy: script-src 'self';");
    
    // Sanitize inputs
    $txt_edit_resident = htmlspecialchars(stripslashes(trim($_POST['txt_edit_resident'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_purpose = htmlspecialchars(stripslashes(trim($_POST['txt_edit_purpose'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_purok = htmlspecialchars(stripslashes(trim($_POST['txt_edit_purok'])), ENT_QUOTES, 'UTF-8');
    
    // Basic Validation
    if (empty($txt_edit_resident) || empty($txt_edit_purpose) || empty($txt_edit_purok)) {
        die('Required fields are missing.');
    }
    
    // Optional: Validate resident name (ensure it only contains letters and spaces)
    if (!preg_match('/^[a-zA-Z\s]+$/', $txt_edit_resident)) {
        die('Invalid resident name format. Only letters and spaces are allowed.');
    }
    
    // Optional: Validate purok (ensure it's numeric, modify the regex if your purok needs a different format)
    if (!preg_match('/^[0-9]+$/', $txt_edit_purok)) {
        die('Invalid purok. Only numbers are allowed.');
    }

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