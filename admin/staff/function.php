<?php
if (isset($_POST['btn_add'])) {
    $txt_name = htmlspecialchars(stripslashes(trim($_POST['txt_name'])));
    $txt_uname = htmlspecialchars(stripslashes(trim($_POST['txt_uname'])));
    $txt_pass = htmlspecialchars(stripslashes(trim($_POST['txt_pass'])));
    $txt_compass = htmlspecialchars(stripslashes(trim($_POST['txt_compass'])));
    $filename = date("mdGis") . ".png";
    $tmp_name = $_FILES['logo']['tmp_name'];
    $folder = "./logo/" . $filename;

    // Log the action if the user has the appropriate role
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator') {
        $action = 'Added Barangay ' . $txt_name;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Administrator', NOW(), '$action')");
    }

    // Check if the username already exists
    $su = mysqli_query($con, "SELECT * FROM tblstaff WHERE username = '$txt_uname'");
    $ct = mysqli_num_rows($su);

    if ($ct == 0) {
        $hashed = password_hash($txt_pass, PASSWORD_DEFAULT);
        $query = mysqli_query($con, "INSERT INTO tblstaff (name, username, password, compass,logo) 
            VALUES ('$txt_name', '$txt_uname', '$hashed', '$hashed', '$filename')") or die('Error: ' . mysqli_error($con));
        if ($query) {
            move_uploaded_file($tmp_name, $folder);
            $_SESSION['added'] = 1;
            header("location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
    } else {
        $_SESSION['duplicateuser'] = 1;
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

if (isset($_POST['btn_save'])) {
    $txt_id = $_POST['hidden_id'];
    $txt_edit_name = htmlspecialchars(stripslashes(trim($_POST['txt_edit_name'])));
    $txt_edit_uname = htmlspecialchars(stripslashes(trim($_POST['txt_edit_uname'])));
    $txt_edit_pass = htmlspecialchars(stripslashes(trim($_POST['txt_edit_pass'])));
    $txt_edit_compass = htmlspecialchars(stripslashes(trim($_POST['txt_edit_compass'])));

    // Log the action if the user has the appropriate role
    if (isset($_SESSION['role'])) {
        $action = 'Updated Barangay ' . $txt_edit_name;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Administrator', NOW(), '$action')");
    }

    // Check if the username already exists
    // $su = mysqli_query($con, "SELECT * FROM tblstaff WHERE username = '$txt_edit_uname'");
    // $ct = mysqli_num_rows($su);

    if ($_FILES['logo']['error'] > 0) {
        if (!empty($txt_edit_pass)) {
            $hashed = password_hash($txt_edit_pass, PASSWORD_DEFAULT);
        $update_query = mysqli_query($con, "UPDATE tblstaff 
            SET name = '$txt_edit_name', username = '$txt_edit_uname', password = '$hashed', compass = '$hashed' 
            WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));
        }else{
            
        $update_query = mysqli_query($con, "UPDATE tblstaff 
            SET name = '$txt_edit_name', username = '$txt_edit_uname'
            WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));
        }
    }else{
        $filename = date("mdGis") . ".png";
        $tmp_name = $_FILES['logo']['tmp_name'];
        $folder = "./logo/" . $filename;

        if (!empty($txt_edit_pass)) {
            $hashed = password_hash($txt_edit_pass, PASSWORD_DEFAULT);
            move_uploaded_file($tmp_name, $folder);
        $update_query = mysqli_query($con, "UPDATE tblstaff 
            SET name = '$txt_edit_name', username = '$txt_edit_uname', password = '$hashed', compass = '$hashed', logo = '$filename' 
            WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));
           
        }else{
            move_uploaded_file($tmp_name, $folder);
        $update_query = mysqli_query($con, "UPDATE tblstaff 
            SET name = '$txt_edit_name', username = '$txt_edit_uname', logo = '$filename' 
            WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));
            
        }
    }

    if ($update_query) {
        $_SESSION['edited'] = 1;
        header("location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

if (isset($_POST['btn_delete'])) {
    if (isset($_POST['chk_delete'])) {
        foreach ($_POST['chk_delete'] as $value) {
            $delete_query = mysqli_query($con, "DELETE FROM tblstaff WHERE id = '$value'") or die('Error: ' . mysqli_error($con));

            if ($delete_query) {
                $_SESSION['delete'] = 1;
                header("location: " . $_SERVER['REQUEST_URI']);
                exit();
            }
        }
    }
}
?>
