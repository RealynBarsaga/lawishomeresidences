<?php
if(isset($_POST['btn_add'])){
    // Sanitize inputs
    $txt_householdno = htmlspecialchars(stripslashes(trim($_POST['txt_householdno'])), ENT_QUOTES, 'UTF-8');
    $txt_totalmembers = (int) $_POST['txt_totalmembers']; // Cast to integer
    $txt_hof = htmlspecialchars(stripslashes(trim($_POST['txt_hof'])), ENT_QUOTES, 'UTF-8');
    $txt_brgy = htmlspecialchars(stripslashes(trim($_POST['txt_brgy'])), ENT_QUOTES, 'UTF-8');
    $txt_purok = htmlspecialchars(stripslashes(trim($_POST['txt_purok'])), ENT_QUOTES, 'UTF-8');
    
    // Basic Validation
    if (empty($txt_householdno) || empty($txt_hof) || empty($txt_brgy) || empty($txt_purok)) {
        die('Required fields are missing.');
    }
    
    // Validate total members (example: ensure it's a positive integer)
    if ($txt_totalmembers <= 0) {
        die('Total members must be a positive number.');
    }
    
    // Optional: Validate household number (example: you can use a regex pattern if household numbers follow a specific format)
    // Example: Check if it's numeric or follows a specific format (modify this regex according to your needs)
    if (!preg_match('/^[0-9]+$/', $txt_householdno)) {
        die('Invalid household number.');
    }

    $chkdup = mysqli_query($con, "SELECT * from tblhousehold where headoffamily = ".$txt_hof."");
    $rows = mysqli_num_rows($chkdup);

    if(isset($_SESSION['role'])){
        $action = 'Added Household Number '.$txt_householdno;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('Brgy.".$_SESSION['staff']."', NOW(), '".$action."')");
    }

    if($rows == 0){
        $query = mysqli_query($con,"INSERT INTO tblhousehold (householdno, totalhouseholdmembers, headoffamily, barangay, purok) 
            values ('$txt_householdno', '$txt_totalmembers', '$txt_hof', '$txt_brgy', '$txt_purok')") or die('Error: ' . mysqli_error($con));
        if($query == true)
        {
            $_SESSION['added'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
            exit();
        }     
    }
    else {
        $_SESSION['duplicate'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if (isset($_POST['btn_save'])) {
   // Sanitize inputs
   $txt_id = htmlspecialchars(stripslashes(trim($_POST['hidden_id'])), ENT_QUOTES, 'UTF-8');
   $txt_edit_householdno = htmlspecialchars(stripslashes(trim($_POST['txt_edit_householdno'])), ENT_QUOTES, 'UTF-8');
   $txt_edit_totalmembers = (int) $_POST['txt_edit_totalmembers']; // Cast to integer
   $txt_edit_name = htmlspecialchars(stripslashes(trim($_POST['txt_edit_name'])), ENT_QUOTES, 'UTF-8');
   $txt_edit_purok = htmlspecialchars(stripslashes(trim($_POST['txt_edit_purok'])), ENT_QUOTES, 'UTF-8');
   $txt_edit_brgy = htmlspecialchars(stripslashes(trim($_POST['txt_edit_brgy'])), ENT_QUOTES, 'UTF-8');
   
   // Basic Validation
   if (empty($txt_id) || empty($txt_edit_householdno) || empty($txt_edit_name) || empty($txt_edit_purok) || empty($txt_edit_brgy)) {
       die('Required fields are missing.');
   }
   
   // Validate total members (ensure it's a positive integer)
   if ($txt_edit_totalmembers <= 0) {
       die('Total members must be a positive number.');
   }
   
   // Validate household number (example: check if it's numeric)
   if (!preg_match('/^[0-9]+$/', $txt_edit_householdno)) {
       die('Invalid household number.');
   }
   
   // Optional: Validate name (ensure it's not just spaces or special characters)
   if (!preg_match('/^[a-zA-Z\s]+$/', $txt_edit_name)) {
       die('Invalid name format. Only letters and spaces are allowed.');
   }

    // Check if columns exist in the table
    $columns = array('householdno', 'totalhouseholdmembers', 'barangay', 'purok'); // Modify these as per your table structure
    $result = mysqli_query($con, "SHOW COLUMNS FROM tblhousehold");
    $valid_columns = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $valid_columns[] = $row['Field'];
    }

    // Make sure columns exist in tblhousehold table
    if (in_array('householdno', $valid_columns) && in_array('totalhouseholdmembers', $valid_columns) && in_array('barangay', $valid_columns) && in_array('purok', $valid_columns)) {
        // Update query using prepared statements
        $stmt = $con->prepare("UPDATE tblhousehold SET householdno = ?, totalhouseholdmembers = ?, barangay = ?, purok = ? WHERE id = ?");
        $stmt->bind_param("sssi", $txt_edit_householdno, $txt_edit_totalmembers, $txt_edit_brgy, $txt_edit_purok, $txt_id);
        $update_query = $stmt->execute();

        // Log action
        if (isset($_SESSION['role'])) {
            $action = 'Update Household Number ' . $txt_edit_householdno;
            $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Brgy." . $_SESSION['staff'] . "', NOW(), '" . $action . "')");
        }

        // Redirect if successful
        if ($update_query) {
            $_SESSION['edited'] = 1;
            header("location: " . $_SERVER['REQUEST_URI']);
            exit(); // Ensure no further execution after redirect
        } else {
            die('Error: ' . $stmt->error);
        }
    } else {
        die('Error: Invalid column names');
    }
}


if(isset($_POST['btn_delete']))
{
    if(isset($_POST['chk_delete']))
    {
        foreach($_POST['chk_delete'] as $value)
        {
            $delete_query = mysqli_query($con,"DELETE from tblhousehold where id = '$value' ") or die('Error: ' . mysqli_error($con));
                    
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
