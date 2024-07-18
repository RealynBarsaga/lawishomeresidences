// update_resident.php
<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $formerAddress = $_POST['formerAddress'];

    $query = "UPDATE tblresident SET fname='$fname', lname='$lname', mname='$mname', age='$age', gender='$gender', formerAddress='$formerAddress' WHERE id='$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $response = array('status' => 'success', 'id' => $id, 'cname' => "$lname, $fname $mname", 'age' => $age, 'gender' => $gender, 'formerAddress' => $formerAddress);
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to update record');
    }
    echo json_encode($response);
}
?>
