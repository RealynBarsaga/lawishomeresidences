<!DOCTYPE html>
<html>
<?php
session_start();
$error = false;

if (isset($_POST['btn_login'])) {
    include "pages/connection.php";

    $username = $_POST['txt_username'];
    $password = $_POST['txt_password'];

    $staff = mysqli_query($con, "SELECT * FROM tblstaff WHERE username = '$username' AND password = '$password'");
    $numrow_staff = mysqli_num_rows($staff);

    if ($numrow_staff > 0) {
        while ($row = mysqli_fetch_array($staff)) {
            $_SESSION['role'] = "Staff";
            $_SESSION['staff'] = $row['name'];
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            switch ($row['id']) {
                case 1:
                    header('Location: pages/household/household.php');
                    break;
                case 2:
                    header('Location: pages1/household/household.php');
                    break;
                //Add more if needed
            }
        }
        exit();
    } else {
        $error = true;
    }
}
?>
<head>
    <meta charset="UTF-8">
    <title>Madridejos Home Residence Management System</title>
    <link rel="icon" type="x-icon" href="img/lg.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="css/AdminLTE.css" rel="stylesheet" type="text/css"/>
</head>
<style>
    body {
      background-image: url('img/received_1185064586170879.jpeg');
      background-attachment: fixed;
      background-position: center center;
      background-repeat: no-repeat;
      background-size: cover; /* Ensures the background image covers the entire container */
      margin: 0;
      padding: 0;
    }
    html {
        height: 100%;
    }
    .panel {
        margin-top: 90px;
    }
    .btn {
        margin-left: 133px;
        width: 70px;
    }
    @media (max-width: 768px) {
      body {
        background-size: contain; /* Adjust the background size for smaller screens */
      }
    }
</style>
<body class="skin-black">
<div class="container" style="margin-top:30px">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading" style="text-align:center;">
                <img src="img/lg.png" style="height:100px;"/>
                <h3 class="panel-title">
                    <strong>
                      Madridejos Home Residence Management System
                    </strong>
                </h3>
            </div>
            <div class="panel-body">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="txt_username">Username</label>
                        <input type="text" class="form-control" style="border-radius:0px" name="txt_username"
                               placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label for="txt_password">Password</label>
                        <input type="password" class="form-control" style="border-radius:0px" name="txt_password"
                               placeholder="Enter Password">
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_login">Login</button>
                </form>
                <!-- Placeholder for alert message -->
                <?php if($error): ?>
                    <div id="error-alert" style="margin-top: 15px;">
                        <div class="alert alert-danger" role="alert">Invalid Account</div>
                    </div>
                <?php endif; ?>
                <!-- <?php if($success): ?>
                    <div id="success-alert" style="margin-top: 15px;">
                        <div class="alert alert-success" role="alert">Login Successful</div>
                    </div>
                <?php endif; ?> -->
            </div>
        </div>
    </div>
</div>
</body>
</html>
