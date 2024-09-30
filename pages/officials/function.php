<?php
if(isset($_POST['btn_add'])){
    $ddl_pos = $_POST['ddl_pos'];
    $txt_cname = $_POST['txt_cname'];
    $txt_contact = $_POST['txt_contact'];
    $txt_address = $_POST['txt_address'];
    $txt_sterm = $_POST['txt_sterm'];
    $txt_eterm = $_POST['txt_eterm'];
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


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_save'])) {
    $id = $_POST['hidden_id'];
    $txt_edit_cname = $_POST['txt_edit_cname'];
    $txt_edit_contact = $_POST['txt_edit_contact'];
    $txt_edit_address = $_POST['txt_edit_address'];
    $txt_edit_sterm = $_POST['txt_edit_sterm'];
    $txt_edit_eterm = $_POST['txt_edit_eterm'];

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