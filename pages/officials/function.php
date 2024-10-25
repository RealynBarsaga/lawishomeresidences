<?php
if(isset($_POST['btn_add'])){
    // Sanitize all inputs
    $ddl_pos = htmlspecialchars(stripslashes(trim($_POST['ddl_pos'])), ENT_QUOTES, 'UTF-8');
    $txt_cname = htmlspecialchars(stripslashes(trim($_POST['txt_cname'])), ENT_QUOTES, 'UTF-8');
    $txt_contact = htmlspecialchars(stripslashes(trim($_POST['txt_contact'])), ENT_QUOTES, 'UTF-8');
    $txt_address = htmlspecialchars(stripslashes(trim($_POST['txt_address'])), ENT_QUOTES, 'UTF-8');
    $txt_sterm = htmlspecialchars(stripslashes(trim($_POST['txt_sterm'])), ENT_QUOTES, 'UTF-8');
    $txt_eterm = htmlspecialchars(stripslashes(trim($_POST['txt_eterm'])), ENT_QUOTES, 'UTF-8');
    $off_barangay = $_SESSION['barangay']; // Assuming barangay is stored in the session

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

if (isset($_POST['btn_save'])) {
    // Sanitize inputs
    $id = htmlspecialchars(stripslashes(trim($_POST['hidden_id'])), ENT_QUOTES, 'UTF-8');
    $completeName = htmlspecialchars(stripslashes(trim($_POST['txt_edit_cname'])), ENT_QUOTES, 'UTF-8');
    $pcontact = htmlspecialchars(stripslashes(trim($_POST['txt_edit_contact'])), ENT_QUOTES, 'UTF-8');
    $paddress = htmlspecialchars(stripslashes(trim($_POST['txt_edit_address'])), ENT_QUOTES, 'UTF-8');
    $termStart = htmlspecialchars(stripslashes(trim($_POST['txt_edit_sterm'])), ENT_QUOTES, 'UTF-8');
    $termEnd = htmlspecialchars(stripslashes(trim($_POST['txt_edit_eterm'])), ENT_QUOTES, 'UTF-8');

    // Handle image upload
    $image = $_FILES['txt_edit_image']['name'];
    if ($image) {
        $target_dir = "image/";
        $target_file = $target_dir . basename($image);
        
        if (move_uploaded_file($_FILES["txt_edit_image"]["tmp_name"], $target_file)) {
            // Image upload successful
        } else {
            // Handle error
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        // Get existing image if no new image is uploaded
        $edit_query = mysqli_query($con, "SELECT image FROM tblbrgyofficial WHERE id='$id'");
        if ($edit_query) {
            $row = mysqli_fetch_array($edit_query);
            $image = $row['image'];
        } else {
            // Handle query error
            die('Error fetching existing image: ' . mysqli_error($con));
        }
    }

    // Logging action
    if (isset($_SESSION['role'])) {
        $action = 'Update Official named ' . $completeName; // Correct variable name
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user, logdate, action) VALUES ('Brgy." . $_SESSION['staff'] . "', NOW(), '$action')");
    }

    // Update official information including image
    $update_query = mysqli_query($con, "UPDATE tblbrgyofficial SET 
        completeName = '$completeName',
        pcontact = '$pcontact', 
        paddress = '$paddress', 
        termStart = '$termStart', 
        termEnd = '$termEnd',
        image = '$image'
        WHERE id = '$id'") or die('Error: ' . mysqli_error($con));

    if ($update_query) {
        $_SESSION['edited'] = 1;
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        // Handle update error
        die('Error updating record: ' . mysqli_error($con));
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