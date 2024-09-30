<!DOCTYPE html>
<html>
<?php
session_start();
$error = false;
$login_success = false; // Add this flag for login success

if (isset($_POST['btn_login'])) {
    include "pages/connection.php";

    $username = htmlspecialchars(stripslashes(trim($_POST['txt_username'])));
    $password = htmlspecialchars(stripslashes(trim($_POST['txt_password'])));

    $staff = mysqli_query($con, "SELECT * from tblstaff where username = '$username'");
    $numrow_staff = mysqli_num_rows($staff);

    if ($numrow_staff > 0) {
        $row = mysqli_fetch_array($staff);
       if (password_verify($password, $row['password'])) {
        $_SESSION['role'] = "Staff";
        $_SESSION['staff'] = $row['name'];
        $_SESSION['userid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION["barangay"] = $row["name"];
        $_SESSION['logo'] = $row['logo'];
        
        // Set login success flag to true
        $login_success = true;
       }else{
            $error = 1;
       }
    } else {
        // Handle login failure
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
    height: 100vh; /* Makes sure the body takes up the full height of the viewport */
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center; /* Vertically centers the content */
    justify-content: center; /* Horizontally centers the content */
}

html {
    height: 100%; /* Ensures the HTML covers the full height */
}

.container {
    max-width: 1061px;
    width: 100%; /* Make sure the container is responsive */
    padding: 15px; /* Add padding to the container */
}

.panel {
    height: 370px;
    min-height: 370px;
    background-image: url('img/background.jpg');
    background-attachment: fixed;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: 70% 70%; /* Ensures the background image covers the entire container */
    border-radius: 10px;
    background-color: rgba(0, 0, 0, 0.6); /* Optional: Add a dark overlay to improve readability */
    padding: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); /* Add shadow for a modern look */
}

.panel-title {
    color: white;
    text-align: center;
}

.form-control {
    border-radius: 34px !important;
    box-shadow: none;
}

.btn {
    margin-left: 70px;
    width: 90px;
    height: 40px;
    border-radius: 25px;
    color: white;
    background: linear-gradient(184deg, rgba(255,0,0,1) 40%, rgba(0,0,0,1) 92%);
    border: none; /* Optional: Remove default border */
    transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition for hover */
}


.btn:hover {
    color: #fff; /* Keep the text white, or change if desired */
    cursor: pointer; /* Change cursor to pointer on hover */
}

.forgot-password {
    text-align: left;
    margin-top: 10px;
}

.forgot-password a {
    color: #337ab7;
    text-decoration: none;
}

.forgot-password a:hover {
    text-decoration: underline;
}

.error, .alert{
    color: white;
    font-size: 12px;
}

.alert {
    position: relative;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    body {
        background-size: cover; /* Keep background image filling the screen */
    }

    .btn {
        margin-left: 0;
        width: 100%;
    }

    .container {
        padding: 10px;
    }

    .panel {
        padding: 10px;
        background-size: contain;
        width: 100%;
    }
}
</style>
<body class="skin-black">
<div class="container" style="margin-top:30px">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-body">
            <form role="form" method="post">
            <div style="text-align:center;">
                    <img src="img/lg.png" style="height:60px;"/>
                    <h3 class="panel-title">
                        <strong>
                            Madridejos Home Residence Management System
                        </strong>
                    </h3>
                </div>
                <br>
                <center>
                    <h7 style="margin-bottom: -42px;font-family: Georgia, serif;font-size: 18px;text-align: center;margin-bottom: -42px; color: white;">USER LOGIN</h7>
                </center>
                <div class="form-group" style="border-radius:1px; border: 25px;">
                        <label for="txt_username"></label>
                        <input type="text" class="form-control" name="txt_username"
                               placeholder="Enter Username" required>

                        <label for="txt_password"></label>
                        <input type="password" class="form-control" name="txt_password"
                               placeholder="Enter Password" required>
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <button type="submit" class="btn btn-sm" name="btn_login" style="font-size: 18px;">Login</button>
                    <!-- Forgot password link -->
                    <!-- <div class="form-group">
                    <div class="forgot-password">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                    </div> -->
            </form>
            <!-- Error message modal and JavaScript for dismiss -->
            <?php if ($error): ?>
                <!-- Error Modal structure -->
                <div id="error-modal" class="modal" style="display: block;">
                    <div class="modal-content">
                        <span class="modal-title">Error</span>
                        <p>Invalid account. Please try again.</p>
                        <button id="error-ok-button" class="btn-ok">OK</button>
                    </div>
                </div>
                <style>
                    /* Modal styles */
                    .modal {
                        position: fixed;
                        z-index: 1000; /* Ensure it's on top */
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5); /* Background overlay */
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
            
                    .modal-content {
                        background: linear-gradient(135deg, #ffdddd, #f7f7f7); /* Soft red gradient for error */
                        padding: 30px; /* Same spacious padding */
                        border-radius: 15px; /* Same rounded corners */
                        text-align: center;
                        width: 350px; /* Same width */
                        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Same shadow effect */
                        position: relative;
                        margin-left: auto;
                        margin-right: auto;
                        margin-top: 220px;
                        animation: modalFadeIn 0.5s ease; /* Same smooth fade-in */
                    }
                    
                    /* Fade-in animation */
                    @keyframes modalFadeIn {
                        from {
                            opacity: 0;
                            transform: scale(0.95); /* Slight scaling for a zoom-in effect */
                        }
                        to {
                            opacity: 1;
                            transform: scale(1);
                        }
                    }
                    
                    /* Add a subtle border */
                    .modal-content {
                        border: 2px solid #e0e0e0; /* Soft border */
                    }
                    
                    /* Optional: Close button */
                    .modal-content .close-btn {
                        position: absolute;
                        top: 10px;
                        right: 15px;
                        background: transparent;
                        border: none;
                        font-size: 18px;
                        cursor: pointer;
                        color: #666;
                        transition: color 0.3s ease;
                    }
                    
                    .modal-content .close-btn:hover {
                        color: #ff5c5c; /* Change color on hover */
                    }
                    
                    /* Optional: Increase spacing between elements */
                    .modal-content p {
                        margin-bottom: 25px; /* Increased margin for better spacing */
                        font-size: 16px; /* Slightly larger text */
                    }
                    .modal-content .btn-ok {
                        background-color: #d9534f; /* Red color for error */
                        color: white;
                        border: none;
                        padding: 12px 25px;
                        border-radius: 25px; /* More rounded button */
                        cursor: pointer;
                        font-size: 16px;
                        transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transition for hover effects */
                    }
                    
                    .modal-content .btn-ok:hover {
                        background-color: #c9302c; /* Darker red on hover */
                        transform: scale(1.05); /* Slight zoom on hover */
                    }
                    /* Optional: Add a subtle footer */
                    .modal-content::after {
                        content: "Powered by Madridejos HRMS";
                        display: block;
                        font-size: 12px;
                        color: #aaa;
                        margin-top: 20px;
                    }

            
                    /* Error modal title */
                    .modal-title {
                        font-size: 18px;
                        font-weight: bold;
                        margin-bottom: 10px;
                        color: #d9534f; /* Red color for error */
                    }
            
                    .btn-ok {
                        background-color: #d9534f; /* Red color for error */
                        color: white;
                        border: none;
                        padding: 12px 25px;
                        border-radius: 25px; /* More rounded button */
                        cursor: pointer;
                        font-size: 16px;
                        transition: background-color 0.3s ease, transform 0.2s ease;
                    }
            
                    .btn-ok:hover {
                        background-color: #c9302c;
                        transform: scale(1.05); /* Slight zoom on hover */
                    }
            
                    /* Add some space between the text and the button */
                    .modal p {
                        margin-bottom: 25px;
                    }
                </style>
            
                <script>
                    // Wait for the DOM to load
                    document.addEventListener("DOMContentLoaded", function() {
                        // Attach a click event to the OK button
                        document.getElementById("error-ok-button").addEventListener("click", function() {
                            // Close the error modal when OK is clicked
                            document.getElementById("error-modal").style.display = 'none';
                        });
                    });
                </script>
            <?php endif; ?>

            <!-- Success message and JavaScript for redirection -->
            <?php if ($login_success): ?>
                <!-- Modal structure -->
                <div id="success-modal" class="modal" style="display: block;">
                    <div class="modal-content">
                        <span class="modal-title">Success</span>
                        <p>Login Successfully!</p>
                        <button id="ok-button" class="btn-ok">OK</button>
                    </div>
                </div>
            
                <style>
                    /* Modal styles */
                    .modal {
                        position: fixed;
                        z-index: 1000; /* Ensure it's on top */
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5); /* Background overlay */
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
            
                    .modal-content {
                        background: linear-gradient(135deg, #ffffff, #f7f7f7); /* Soft gradient background */
                        padding: 30px; /* Increased padding for a spacious look */
                        border-radius: 15px; /* Slightly more rounded corners */
                        text-align: center;
                        width: 350px; /* Slightly wider */
                        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Deeper shadow for a more elevated effect */
                        position: relative; /* Allows for positioning of close button */
                        margin-left: auto;
                        margin-right: auto;
                        margin-top: 220px;
                        animation: modalFadeIn 0.5s ease; /* Smooth fade-in animation */
                    }
                    
                    /* Fade-in animation */
                    @keyframes modalFadeIn {
                        from {
                            opacity: 0;
                            transform: scale(0.95); /* Slight scaling for a zoom-in effect */
                        }
                        to {
                            opacity: 1;
                            transform: scale(1);
                        }
                    }
                    
                    /* Add a subtle border */
                    .modal-content {
                        border: 2px solid #e0e0e0; /* Soft border */
                    }
                    
                    /* Optional: Close button */
                    .modal-content .close-btn {
                        position: absolute;
                        top: 10px;
                        right: 15px;
                        background: transparent;
                        border: none;
                        font-size: 18px;
                        cursor: pointer;
                        color: #666;
                        transition: color 0.3s ease;
                    }
                    
                    .modal-content .close-btn:hover {
                        color: #ff5c5c; /* Change color on hover */
                    }
                    
                    /* Optional: Increase spacing between elements */
                    .modal-content p {
                        margin-bottom: 25px; /* Increased margin for better spacing */
                        font-size: 16px; /* Slightly larger text */
                    }
                    
                    .modal-content .btn-ok {
                        background-color: #4CAF50;
                        color: white;
                        border: none;
                        padding: 12px 25px;
                        border-radius: 25px; /* More rounded button */
                        cursor: pointer;
                        font-size: 16px;
                        transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transition for hover effects */
                    }
                    
                    .modal-content .btn-ok:hover {
                        background-color: #45a049;
                        transform: scale(1.05); /* Slight zoom on hover */
                    }
                    
                    /* Optional: Add a subtle footer */
                    .modal-content::after {
                        content: "Powered by Madridejos HRMS";
                        display: block;
                        font-size: 12px;
                        color: #aaa;
                        margin-top: 20px;
                    }

            
                    .modal-title {
                        font-size: 18px;
                        font-weight: bold;
                        margin-bottom: 10px;
                    }
            
                    .btn-ok {
                        background-color: #4CAF50;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 16px;
                        margin-top: 10px;
                        transition: background-color 0.3s ease;
                    }
            
                    .btn-ok:hover {
                        background-color: #45a049;
                    }
            
                    /* Add some space between the text and the button */
                    .modal p {
                        margin-bottom: 20px;
                    }
                </style>
            
                <script>
                    // Wait for the DOM to load
                    document.addEventListener("DOMContentLoaded", function() {
                        // Attach a click event to the OK button
                        document.getElementById("ok-button").addEventListener("click", function() {
                            // Redirect to the dashboard after the OK button is clicked
                            window.location.href = 'pages/dashboard/dashboard.php?page=dashboard';
                        });
                    });
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>