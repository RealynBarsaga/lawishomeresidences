<?php
if(isset($_POST['btn_add'])){
    // Set Content Security Policy
    header("Content-Security-Policy: script-src 'self';");

    // Sanitize all inputs
    $ddl_pos = htmlspecialchars(stripslashes(trim($_POST['ddl_pos'])), ENT_QUOTES, 'UTF-8');
    $txt_cname = htmlspecialchars(stripslashes(trim($_POST['txt_cname'])), ENT_QUOTES, 'UTF-8');
    $txt_contact = htmlspecialchars(stripslashes(trim($_POST['txt_contact'])), ENT_QUOTES, 'UTF-8');
    $txt_address = htmlspecialchars(stripslashes(trim($_POST['txt_address'])), ENT_QUOTES, 'UTF-8');
    $txt_sterm = htmlspecialchars(stripslashes(trim($_POST['txt_sterm'])), ENT_QUOTES, 'UTF-8');
    $txt_eterm = htmlspecialchars(stripslashes(trim($_POST['txt_eterm'])), ENT_QUOTES, 'UTF-8');
    $off_barangay = $_SESSION['barangay']; // Assuming barangay is stored in the session
    
    // Optional: Validate specific fields (example)
    if (empty($ddl_pos) || empty($txt_cname) || empty($txt_contact)) {
        die('Required fields are missing.');
    }
    
    // Additional validation for contact (example: check if it's numeric or follows a specific format)
    if (!preg_match('/^[0-9]+$/', $txt_contact)) {
        die('Invalid contact number.');
    }

    // Handle file upload
    $name = basename($_FILES['image']['name']);
    $temp = $_FILES['image']['tmp_name'];
    $imagetype = $_FILES['image']['type'];
    $size = $_FILES['image']['size'];
    $milliseconds = round(microtime(true) * 1000); // Add unique timestamp to image name
    $image = $milliseconds . '_' . $name;

    $target_dir = "image/";
    $target_file = $target_dir . $image;

    // Validate the image file
    if (($imagetype == "image/jpeg" || $imagetype == "image/png" || $imagetype == "image/bmp") && $size <= 2048000) {
        if (move_uploaded_file($temp, $target_file)) {
            // Image successfully uploaded
            if(isset($_SESSION['role'])){
                $action = 'Added Official named '.$txt_cname;
                $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Brgy.".$_SESSION['staff']."', NOW(), '".$action."')");
            }

            // Check if the same name already exists
            $q = mysqli_query($con, "SELECT * FROM tblbrgyofficial WHERE completeName = '".$txt_cname."'");
            $ct = mysqli_num_rows($q);

            if($ct == 0){
                $query = mysqli_query($con, "INSERT INTO tblbrgyofficial (sPosition, completeName, pcontact, paddress, termStart, termEnd, status, barangay, image) 
                VALUES ('$ddl_pos', '$txt_cname', '$txt_contact', '$txt_address', '$txt_sterm', '$txt_eterm', 'Ongoing Term', '$off_barangay', '$image')") 
                or die('Error: ' . mysqli_error($con));
                
                if($query == true) {
                    $_SESSION['added'] = 1;
                    header("location: ".$_SERVER['REQUEST_URI']);
                    exit();
                }
            } else {
                $_SESSION['duplicate'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
        } else {
            // Handle file move error
            echo "Error uploading image.";
        }
    } else {
        $_SESSION['filesize'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_save'])) {
    // Set Content Security Policy
    header("Content-Security-Policy: script-src 'self';");

    // Sanitize inputs
    $id = htmlspecialchars(stripslashes(trim($_POST['hidden_id'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_cname = htmlspecialchars(stripslashes(trim($_POST['txt_edit_cname'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_contact = htmlspecialchars(stripslashes(trim($_POST['txt_edit_contact'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_address = htmlspecialchars(stripslashes(trim($_POST['txt_edit_address'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_sterm = htmlspecialchars(stripslashes(trim($_POST['txt_edit_sterm'])), ENT_QUOTES, 'UTF-8');
    $txt_edit_eterm = htmlspecialchars(stripslashes(trim($_POST['txt_edit_eterm'])), ENT_QUOTES, 'UTF-8');
    
    // Basic Validation
    if (empty($txt_edit_cname) || empty($txt_edit_contact) || empty($txt_edit_address)) {
        die('Required fields are missing.');
    }
    
    // Validate contact (example: assuming it should be numeric)
    if (!preg_match('/^[0-9]+$/', $txt_edit_contact)) {
        die('Invalid contact number.');
    }
    
    // Optional: Validate start and end term (e.g., date validation if these represent dates)
    if (!empty($txt_edit_sterm) && !empty($txt_edit_eterm)) {
        $start_date = DateTime::createFromFormat('Y-m-d', $txt_edit_sterm);
        $end_date = DateTime::createFromFormat('Y-m-d', $txt_edit_eterm);
    
        if (!$start_date || !$end_date) {
            die('Invalid date format. Please use YYYY-MM-DD.');
        }
    
        if ($start_date > $end_date) {
            die('Start term cannot be after end term.');
        }
    }

    // Handle image upload
    $image = $_FILES['txt_edit_image']['name'];
    if ($image) {
        $target_dir = "image/";
        $target_file = $target_dir . basename($_FILES["txt_edit_image"]["name"]);
        move_uploaded_file($_FILES["txt_edit_image"]["tmp_name"], $target_file);
    } else {
        $edit_query = mysqli_query($con, "SELECT image FROM tblbrgyofficial WHERE id='$id'");
        $row = mysqli_fetch_array($edit_query);
        $image = $row['image'];
    }
    if ($edit_query == true) {
        $_SESSION['edited'] = 1;
        header("location: " . $_SERVER['REQUEST_URI']);
    }

    // Logging action
    if (isset($_SESSION['role'])) {
        $action = 'Update Official named ' . $txt_edit_cname;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Brgy." . $_SESSION['staff'] . "', NOW(), '$action')");
    }

    // Update official information including image
    $update_query = mysqli_query($con, "UPDATE tblbrgyofficial SET 
        completeName = '$txt_edit_cname', 
        pcontact = '$txt_edit_contact', 
        paddress = '$txt_edit_address', 
        termStart = '$txt_edit_sterm', 
        termEnd = '$txt_edit_eterm',
        image = '$image'
        WHERE id = '$txt_id'") or die('Error: ' . mysqli_error($con));

    if ($update_query) {
        $_SESSION['edited'] = 1;
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}


if(isset($_POST['btn_end']))
{

    $txt_id = $_POST['hidden_id'];

    $end_query = mysqli_query($con,"UPDATE tblbrgyofficial set status = 'End Term' where id = '$txt_id' ") or die('Error: ' . mysqli_error($con));

    if($end_query == true){
        $_SESSION['end'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['btn_start']))
{

    $txt_id = $_POST['hidden_id'];

    $start_query = mysqli_query($con,"UPDATE tblbrgyofficial set status = 'Ongoing Term' where id = '$txt_id' ") or die('Error: ' . mysqli_error($con));

    if($start_query == true){
        $_SESSION['start'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['btn_delete']))
{
    if(isset($_POST['chk_delete']))
    {
        foreach($_POST['chk_delete'] as $value)
        {
            $delete_query = mysqli_query($con,"DELETE from tblbrgyofficial where id = '$value' ") or die('Error: ' . mysqli_error($con));
                    
            if($delete_query == true)
            {
                $_SESSION['delete'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
            }
        }
    }
}
?>