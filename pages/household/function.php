<?php
ob_start();

if(isset($_POST['btn_add'])){
    $txt_householdno = $_POST['txt_householdno'];
    $txt_totalmembers = $_POST['txt_totalmembers'];
    $txt_hof = $_POST['txt_hof'];
   /*  $txt_purok = $_POST['txt_purok']; */

    $chkdup = mysqli_query($con, "SELECT * from tblhousehold where householdno = ".$txt_householdno."");
    $rows = mysqli_num_rows($chkdup);

    if(isset($_SESSION['role'])){
        $action = 'Added Household Number '.$txt_householdno;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('".$_SESSION['staff']."', NOW(), '".$action."')");
    }

    if($rows == 0){
        $query = mysqli_query($con,"INSERT INTO tblhousehold (householdno, totalhouseholdmembers, headoffamily) 
            values ('$txt_householdno', '$txt_totalmembers', '$txt_hof')") or die('Error: ' . mysqli_error($con));
        if($query == true)
        {
            $_SESSION['added'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
            ob_end_flush();
        }     
    }
    else {
        $_SESSION['duplicate'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        ob_end_flush();
    }
}

if (isset($_POST['btn_save'])) {
    $txt_id = $_POST['hidden_id'];
    $txt_edit_householdno = $_POST['txt_edit_householdno'];
    $txt_edit_totalmembers = $_POST['txt_edit_totalmembers'];
    $txt_edit_name = $_POST['txt_edit_name'];
    $txt_edit_purok = $_POST['txt_edit_purok'];

    // Check if columns exist in the table
    $columns = array('householdno', 'totalhouseholdmembers', 'purok'); // Modify these as per your table structure
    $result = mysqli_query($con, "SHOW COLUMNS FROM tblhousehold");
    $valid_columns = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $valid_columns[] = $row['Field'];
    }

    // Make sure columns exist in tblhousehold table
    if (in_array('householdno', $valid_columns) && in_array('totalhouseholdmembers', $valid_columns) && in_array('purok', $valid_columns)) {
        // Update query using prepared statements
        $stmt = $con->prepare("UPDATE tblhousehold SET householdno = ?, totalhouseholdmembers = ?, purok = ? WHERE id = ?");
        $stmt->bind_param("sssi", $txt_edit_householdno, $txt_edit_totalmembers, $txt_edit_purok, $txt_id);
        $update_query = $stmt->execute();

        // Log action
        if (isset($_SESSION['role'])) {
            $action = 'Update Household Number ' . $txt_edit_householdno;
            $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('" . $_SESSION['staff'] . "', NOW(), '" . $action . "')");
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
                ob_end_flush();
            }
        }
    }
}
?>
