<?php
include('../connection.php');

// Handle form submission for adding a resident
if (isset($_POST['btn_add'])) {
    $txt_lname = $_POST['txt_lname'];
    $txt_fname = $_POST['txt_fname'];
    $txt_mname = $_POST['txt_mname'];
    $ddl_gender = $_POST['ddl_gender'];
    $txt_bdate = $_POST['txt_bdate'];
    $txt_bplace = $_POST['txt_bplace'];

    // Calculate age based on birthdate
    $dateOfBirth = $txt_bdate;
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $txt_age = $diff->format('%y');

    // Continue with your other form data
    $txt_brgy = $_POST['txt_brgy'];
    $txt_purok = $_POST['txt_purok'];
    $txt_householdmem = $_POST['txt_householdmem'];
    $txt_cstatus = $_POST['txt_cstatus'];
    $txt_householdnum = $_POST['txt_householdnum'];
    $txt_religion = $_POST['txt_religion'];
    $txt_national = $_POST['txt_national'];
    $ddl_hos = $_POST['ddl_hos'];
    $ddl_los = $_POST['ddl_los'];
    $txt_lightning = $_POST['txt_lightning'];
    $txt_faddress = $_POST['txt_faddress'];

    $name = basename($_FILES['txt_image']['name']);
    $temp = $_FILES['txt_image']['tmp_name'];
    $imagetype = $_FILES['txt_image']['type'];
    $size = $_FILES['txt_image']['size'];

    $milliseconds = round(microtime(true) * 1000);
    $image = $milliseconds . '_' . $name;

    if (isset($_SESSION['role'])) {
        $action = 'Added Resident named of ' . $txt_fname . ' ' . $txt_mname . ' ' . $txt_lname;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('" . $_SESSION['staff'] . "', NOW(), '" . $action . "')");
    }

    $su = mysqli_query($con, "SELECT * FROM tblbunakan WHERE lname='$txt_lname' AND fname='$txt_fname' AND mname='$txt_mname'");
    $ct = mysqli_num_rows($su);

    if ($ct == 0) {
        if ($name != "") {
            if (($imagetype == "image/jpeg" || $imagetype == "image/png" || $imagetype == "image/bmp") && $size <= 2048000) {
                if (move_uploaded_file($temp, 'image/' . $image)) {
                    $txt_image = $image;
                    $query = mysqli_query($con, "INSERT INTO tblbunakan (
                                        lname,
                                        fname,
                                        mname,
                                        bdate,
                                        bplace,
                                        age,
                                        barangay,
                                        purok,
                                        totalhousehold,
                                        civilstatus,
                                        householdnum,
                                        religion,
                                        nationality,
                                        gender,
                                        houseOwnershipStatus,
                                        landOwnershipStatus,
                                        lightningFacilities,
                                        formerAddress,
                                        image
                                    ) 
                                    VALUES (
                                        '$txt_lname', 
                                        '$txt_fname', 
                                        '$txt_mname',  
                                        '$txt_bdate', 
                                        '$txt_bplace',
                                        '$txt_age',
                                        '$txt_brgy',
                                        '$txt_purok',
                                        '$txt_householdmem',
                                        '$txt_cstatus',
                                        '$txt_householdnum',
                                        '$txt_religion',
                                        '$txt_national',
                                        '$ddl_gender',
                                        '$ddl_hos',
                                        '$ddl_los', 
                                        '$txt_lightning',  
                                        '$txt_faddress', 
                                        '$txt_image'
                                    )") or die('Error: ' . mysqli_error($con));
                } else {
                    // Handle file move error
                }
            } else {
                $_SESSION['filesize'] = 1;
                header("location: " . $_SERVER['REQUEST_URI']);
            }
        } else {
            $txt_image = 'default.png';
            $query = mysqli_query($con, "INSERT INTO tblbunakan (
                                        lname,
                                        fname,
                                        mname,
                                        bdate,
                                        bplace,
                                        age,
                                        barangay,
                                        purok,
                                        totalhousehold,
                                        civilstatus,
                                        householdnum,
                                        religion,
                                        nationality,
                                        gender,
                                        houseOwnershipStatus,
                                        landOwnershipStatus,
                                        lightningFacilities,
                                        formerAddress,
                                        image
                                    ) 
                                    VALUES (
                                        '$txt_lname', 
                                        '$txt_fname', 
                                        '$txt_mname',  
                                        '$txt_bdate', 
                                        '$txt_bplace',
                                        '$txt_age',
                                        '$txt_brgy',
                                        '$txt_purok',
                                        '$txt_householdmem',
                                        '$txt_cstatus',
                                        '$txt_householdnum',
                                        '$txt_religion',
                                        '$txt_national',
                                        '$ddl_gender',
                                        '$ddl_hos',
                                        '$ddl_los', 
                                        '$txt_lightning',  
                                        '$txt_faddress', 
                                        '$txt_image'
                                    )") or die('Error: ' . mysqli_error($con));
        }

        if ($query == true) {
            $_SESSION['added'] = 1;
            header("location: " . $_SERVER['REQUEST_URI']);
        }
    } else {
        $_SESSION['duplicateuser'] = 1;
        header("location: " . $_SERVER['REQUEST_URI']);
    }
}

// Handle form submission for editing a resident
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_save'])) {
    // Get form data
    $id = $_POST['hidden_id'];
    $lname = $_POST['txt_edit_lname'];
    $fname = $_POST['txt_edit_fname'];
    $mname = $_POST['txt_edit_mname'];
    $age = $_POST['txt_edit_age'];
    $bdate = $_POST['txt_edit_bdate'];
    $barangay = $_POST['txt_edit_brgy'];
    $purok = $_POST['txt_edit_purok'];
    $householdnum = $_POST['txt_edit_householdnum'];
    $cstatus = $_POST['txt_edit_cstatus'];
    $nationality = $_POST['txt_edit_national'];
    $landOwnershipStatus = $_POST['ddl_edit_los'];
    $gender = $_POST['ddl_edit_gender'];
    $bplace = $_POST['txt_edit_bplace'];
    $totalhousehold = $_POST['txt_edit_householdmem'];
    $religion = $_POST['txt_edit_religion'];
    $houseOwnershipStatus = $_POST['ddl_edit_hos'];
    $lightning = $_POST['txt_edit_lightning'];
    $formerAddress = $_POST['txt_edit_faddress'];

    // Handle image upload
    $image = $_FILES['txt_edit_image']['name'];
    if ($image) {
        $target_dir = "image/";
        $target_file = $target_dir . basename($_FILES["txt_edit_image"]["name"]);
        move_uploaded_file($_FILES["txt_edit_image"]["tmp_name"], $target_file);
    } else {
        $edit_query = mysqli_query($con, "SELECT image FROM tblbunakan WHERE id='$id'");
        $erow = mysqli_fetch_array($edit_query);
        $image = $erow['image'];
    }
    if ($edit_query == true) {
        $_SESSION['edited'] = 1;
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    // Log action
    if (isset($_SESSION['role'])) {
        $action = 'Update Resident info of ' . $fname . ' ' . $mname . ' ' . $lname;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('" . $_SESSION['staff'] . "', NOW(), '" . $action . "')");
    }

    // Update resident's information
    $update_query = mysqli_query($con, "UPDATE tblbunakan SET 
              lname = '$lname', 
              fname = '$fname', 
              mname = '$mname', 
              age = '$age',
              bdate = '$bdate', 
              barangay = '$barangay',
              purok = '$purok', 
              householdnum = '$householdnum', 
              civilstatus = '$cstatus', 
              nationality= '$nationality', 
              landOwnershipStatus = '$landOwnershipStatus', 
              gender = '$gender', 
              bplace = '$bplace', 
              totalhousehold = '$totalhousehold', 
              religion = '$religion', 
              houseOwnershipStatus = '$houseOwnershipStatus', 
              lightningFacilities = '$lightning', 
              formerAddress = '$formerAddress', 
              image = '$image' 
              WHERE id = '$id' ") or die('Error: ' . mysqli_error($con));

    // Redirect after successful update
    if ($update_query) {
        $_SESSION['update'] = 1;
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}


// Handle deletion of residents
if (isset($_POST['btn_delete'])) {
    if (isset($_POST['chk_delete'])) {
        foreach ($_POST['chk_delete'] as $value) {
            $delete_query = mysqli_query($con, "DELETE FROM tblbunakan WHERE id = '$value' ") or die('Error: ' . mysqli_error($con));

            if ($delete_query == true) {
                $_SESSION['delete'] = 1;
                header("location: " . $_SERVER['REQUEST_URI']);
            }
        }
    }
}
?>
