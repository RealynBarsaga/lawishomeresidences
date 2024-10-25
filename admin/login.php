<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$error = false;
$login_success = false;
$error_attempts = false;

$username_or_email = "";

// Set a limit for the number of allowed attempts and lockout time (in seconds)
$max_attempts = 3;
$lockout_time = 300; // 5 minutes (300 seconds)

// Check if the user has been locked out
if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    $remaining_lockout = $_SESSION['lockout_time'] - time();
    $error_attempts = "Too many failed attempts. Please try again in " . ceil($remaining_lockout / 60) . " minute(s).";
} else {
    // Reset attempts after lockout period ends
    if (isset($_SESSION['lockout_time']) && time() > $_SESSION['lockout_time']) {
        unset($_SESSION['login_attempts']);
        unset($_SESSION['lockout_time']);
    }

    // Process login attempt
    if (isset($_POST['btn_login'])) {
        include "connection.php";

        // Retrieve and sanitize input values
        $username_or_email = htmlspecialchars(stripslashes(trim($_POST['txt_username'])));
        $password = htmlspecialchars(stripslashes(trim($_POST['txt_password'])));

        // Check the number of login attempts
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM tbluser WHERE (username = ? OR email = ?) AND type = 'administrator'");
        $stmt->bind_param('ss', $username_or_email, $username_or_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $numrow_admin = $result->num_rows;

        if ($numrow_admin > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                // Reset login attempts upon successful login
                $_SESSION['login_attempts'] = 0;

                // Store user details in session
                $_SESSION['role'] = "Administrator";
                $_SESSION['userid'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                // Set login success flag to true
                $login_success = true;
            } else {
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] < $max_attempts) {
                    $error = true;
                }
            }
        } else {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] < $max_attempts) {
                $error = true;
            }
        }

        // Lock out the user after the max number of attempts
        if ($_SESSION['login_attempts'] >= $max_attempts) {
            $_SESSION['lockout_time'] = time() + $lockout_time;
            $error_attempts = "Too many failed attempts. Please try again in 5 minute(s).";
            $error = false; // Stop showing the "Invalid account" message
        }

        // Close the prepared statement and connection
        $stmt->close();
        $con->close();
    }
}
?>
<head>
    <meta charset="UTF-8">
    <title>Madridejos Home Residence Management System</title>
    <link rel="icon" type="x-icon" href="../img/lg.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js" defer></script>

</head>
<style>
body {
    background-image: url('../img/received_1185064586170879.jpeg');
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
    height: 455px;
    min-height: 370px;
    width: 345px;
    margin-left: 0px;
    background-image: url('../img/bg.jpg');
    background-attachment: fixed;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: 30% 100%; /* Ensures the background image covers the entire container */
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
    border-radius: 8px !important;
    box-shadow: none;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.btn {
    margin-left: -9px;
    width: 300px;
    height: 40px;
    border-radius: 15px;
    color: #000000;
    cursor: pointer;
    background: transparent;
    border: 1px solid #000;
}
.btn:hover {
    border: 1px solid #000;
    color:  #000000;
    cursor: pointer;
}
.forgot-password {
    margin-top: -89px;
}
.forgot-password a {
    text-decoration: none;
    color: #000000;
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
        width: 109%;
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
/* Cookies Cite */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  min-height: 100vh;
}
.wrapper {
  position: fixed;
  bottom: 26px;
  min-height: 36%;
  right: -370px;
  max-width: 345px;
  width: 100%;
  background: #fff;
  border-radius: 8px;
  padding: 15px 25px 22px;
  transition: right 0.3s ease;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}
.wrapper.show {
  right: 14px;
}
.wrapper header {
  display: flex;
  align-items: center;
  column-gap: 15px;
}
header i {
  color: #f90404b3;
  font-size: 32px;
}
header h2 {
  color: #4070f4;
  font-weight: 500;
  margin-top: 14px;
}
.wrapper .data {
  margin-top: 16px;
}
.wrapper .data p {
  color: #333;
  font-size: 16px;
}
.data p a {
  color: #f60000;
  text-decoration: none;
}
.data p a:hover {
  text-decoration: underline;
}
.wrapper .buttons {
  margin-top: 16px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.buttons .button {
  border: none;
  color: #000000;
  padding: 8px 0;
  border-radius: 4px;
  font-size: 12px;
  cursor: pointer;
  border: 1px solid #000000;
  width: calc(100% / 2 - 10px);
}
#acceptBtn{
    background-image: url('../img/bg.jpg');
    color: #fff;
}
.buttons #acceptBtn:hover {
  color: #fff;
  cursor: pointer;
}
#declineBtn {
    background: transparent;
}
#declineBtn:hover {
  color: #000;
  cursor: pointer;
} 

/* Modal styles for "Too many failed attempts" */
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
    background: linear-gradient(135deg, #ffcccb, #f7f7f7); /* Soft red gradient for warning */
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
    border: 2px solid #e0e0e0;
}
.modal-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #d9534f; /* Red color for warning */
}
.modal-content .btn-ok {
    background-color: #f0ad4e; /* Orange for warning */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}
.modal-content .btn-ok:hover {
    background-color: #ec971f;
    transform: scale(1.05);
}
.modal p {
    margin-bottom: 25px;
    font-size: 16px;
}
/* Optional: Add a subtle footer */
.modal-content::after {
    content: "Powered by Madridejos HRMS";
    display: block;
    font-size: 12px;
    color: #aaa;
    margin-top: 20px;
}




/* Modal styles */
.modal1 {
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
.modal-content1 {
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
.modal-content1 {
    border: 2px solid #e0e0e0; /* Soft border */
}
/* Optional: Close button */
.modal-content1 .close-btn {
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
.modal-content1 .close-btn:hover {
    color: #ff5c5c; /* Change color on hover */
}
/* Optional: Increase spacing between elements */
.modal-content1 p {
    margin-bottom: 25px; /* Increased margin for better spacing */
    font-size: 16px; /* Slightly larger text */
}
.modal-content1 .btn-ok1 {
    background-color: #d9534f; /* Red color for error */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px; /* More rounded button */
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transition for hover effects */
}
.modal-content1 .btn-ok1:hover {
    background-color: #c9302c; /* Darker red on hover */
    transform: scale(1.05); /* Slight zoom on hover */
}
/* Optional: Add a subtle footer */
.modal-content1::after {
    content: "Powered by Madridejos HRMS";
    display: block;
    font-size: 12px;
    color: #aaa;
    margin-top: 20px;
}
/* Error modal title */
.modal-title1 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #d9534f; /* Red color for error */
}
.btn-ok1 {
    background-color: #d9534f; /* Red color for error */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px; /* More rounded button */
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}
.btn-ok1:hover {
    background-color: #c9302c;
    transform: scale(1.05); /* Slight zoom on hover */
}
/* Add some space between the text and the button */
.modal1 p {
    margin-bottom: 25px;
}


/* Modal styles */
.modal2 {
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
.modal-content2 {
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
.modal-content2 {
    border: 2px solid #e0e0e0; /* Soft border */
}
/* Optional: Close button */
.modal-content2 .close-btn {
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
.modal-content2 .close-btn:hover {
    color: #ff5c5c; /* Change color on hover */
}
/* Optional: Increase spacing between elements */
.modal-content2 p {
    margin-bottom: 25px; /* Increased margin for better spacing */
    font-size: 16px; /* Slightly larger text */
}
.modal-content2 .btn-ok2 {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px; /* More rounded button */
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transition for hover effects */
}  
.modal-content2 .btn-ok2:hover {
    background-color: #45a049;
    transform: scale(1.05); /* Slight zoom on hover */
} 
/* Optional: Add a subtle footer */
.modal-content2::after {
    content: "Powered by Madridejos HRMS";
    display: block;
    font-size: 12px;
    color: #aaa;
    margin-top: 20px;
}
.modal-title2 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}
.btn-ok2 {
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
.btn-ok2:hover {
    background-color: #45a049;
}
/* Add some space between the text and the button */
.modal2 p {
    margin-bottom: 20px;
}
.input-group {
    position: relative; /* Make sure input-group has relative positioning */
}
.input-group .form-control {
    padding-right: 40px; /* Add padding to the right for the input */
}
.input-group .input-group-text {
    position: absolute; /* Position the eye icon absolutely */
    right: 10px; /* Adjust the right position */
    top: 50%; /* Center vertically */
    transform: translateY(-50%); /* Adjust for centering */
    background-color: transparent; /* Make background transparent */
    border: none; /* Remove border */
    cursor: pointer; /* Change cursor to pointer */
}
.input-group-text i {
    opacity: 0.5; /* Set initial opacity */
    transition: opacity 0.3s; /* Smooth transition */
}  
.input-group-text:hover i {
    opacity: 1; /* Increase opacity on hover */
}
/* Modal Background */
.modal {
    position: fixed;
    background: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    padding: 20px; /* Added padding for small screens */
}
.modal-content3{
    padding: 30px;
    border-radius: 15px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 15px;
    animation: modalFadeIn 0.5s ease;
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
/* Modal Inner */
#s-inr {
    background: white;
    border-radius: 8px;
    width: 100%;
    max-width: 604px;
    max-height: 530px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}
/* Header */
#s-hdr {
    padding: 3px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between; /* Align title and close button */
    align-items: center;
}
#s-ttl {
    margin: 0;
    font-size: 1.5rem; /* Adjusted for better responsiveness */
    margin-left: -4px;
    margin-top: 1px;
}
/* Close Button */
#s-c-bn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 2rem; /* Increased size for better touch */
}
/* Block Elements */
.c-bl {
    padding: 3px;
    border-bottom: 1px solid #ddd;
}
.c-bl:last-child {
    border-bottom: none;
}
.title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px;
}
/* Description */
.desc {
    margin-top: 8px;
    font-size: 0.875rem; /* Smaller font for descriptions */
    color: #555;
}
/* Toggle */
.b-tg {
    display: flex;
    align-items: center;
}
.c-tgl {
    margin-right: 8px;
}
.c-tg {
    position: relative;
    width: 50px; /* Width of the toggle */
    height: 24px; /* Height of the toggle */
    background-color: #ccc; /* Background color for off state */
    border-radius: 50px; /* Rounded corners */
    cursor: pointer;
    transition: background-color 0.3s;
}
.c-tg .on-i, .c-tg .off-i {
    width: 16px;
    height: 16px;
    border-radius: 50%;
}
.c-tg .on-i {
    position: absolute;
    top: 0;
    left: 15px;
    background: green;
    transition: transform 0.3s;
}
.c-tg .off-i {
    position: absolute;
    top: 0;
    left: 0;
    background: red;
}
.c-tgl:checked + .c-tg {
    background: #4CAF50;
}
.c-tgl:checked + .c-tg .on-i {
    transform: translateX(-15px);
}
/* Buttons */
#s-bns {
    display: flex;
    justify-content: space-between;
    padding: 16px;
    border-top: 1px solid #ddd;
}
/* Ensure the buttons are visible */
#s-bns {
    display: flex;
    justify-content: space-between;
    padding: 16px;
    border-top: 1px solid #ddd;
    background: white; /* Ensure background for contrast */
}
.c-bn {
    background-image: url('../img/bg.jpg'); /* Ensure the button color is visible */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s;
    flex: 1; /* Makes buttons flexible */
    margin: 0 5px; /* Space between buttons */
    margin-left: -16px;
    max-width: 124px;
}
/* Accessibility */
[aria-hidden="true"] {
    display: none;
}
/* Responsive Design */
@media (max-width: 600px) {
    #s-ttl {
        font-size: 1.25rem; /* Smaller title */
    }
    .c-bl {
        padding: 12px; /* Smaller padding for mobile */
    }
    .desc {
        font-size: 0.75rem; /* Smaller description font */
    }
    .c-bn {
        font-size: 0.875rem; /* Smaller button font */
    }
}
#s-bl {
    width: 546px; /* Adjust width as needed */
}
.scrollable {
    max-height: 400px; /* Set the height you want */
    overflow-y: auto;  /* Enables vertical scrolling */
    border: 1px solid #ccc; /* Optional: adds a border */
    padding: 10px; /* Optional: adds some padding */
    background-color: #f9f9f9; /* Optional: background color */
}
</style>
<body class="skin-black">
<div class="container" style="margin-top: -5px;">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-body">
            <div style="text-align:center;margin-top:-28px;">
                    <img src="../img/lg.png" style="height:60px;"/>
                    <h3 class="panel-title">
                        <strong>
                            Madridejos Home Residence Management System
                        </strong>
                    </h3>
                    <br>
                    <center style="margin-top: -5px;">
                       <h7 style="margin-bottom: -42px;font-family: Georgia, serif;font-size: 18px;text-align: center;margin-bottom: -42px; color: white;">ADMIN LOGIN</h7>
                    </center>
                </div>
                <form role="form" method="post"  onsubmit="return validateRecaptcha()">
                    <div class="form-group" style="border-radius:1px; border: 25px;">
                        <label for="txt_username" style="color:#fff;margin-left: -8px;font-weight: lighter;">Email</label>
                        <input type="email" class="form-control" name="txt_username"
                               placeholder="jose@gmail.com" required value="<?php echo $username_or_email ?>" style="margin-top: -5px;width: 300px;margin-left: -11px;">
    
                        <label for="txt_password" style="color:#fff;margin-left: -8px;font-weight: lighter;">Password</label>
                        <div style="position: relative; width: 300px; margin-left: -11px;">
                            <input type="password" class="form-control" name="txt_password" id="txt_password"
                                   placeholder="************" required style="padding-right: 40px; margin-top: -4px; width: 100%;"
                                   pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,}$"
                                   title="Password must be at least 10 characters long, contain at least one uppercase letter, one number, and one special character.">
                            
                            <span class="input-group-text" onclick="togglePassword('txt_password', this)" 
                                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; background-color: transparent; border: none;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <div class="form-group" style="margin-top: 5px; width: 3px; margin-left: -11px; transform: scale(0.99); transform-origin: 0 0;">
                            <div class="g-recaptcha" data-sitekey="6Lc2slYqAAAAACs0mn07_8egSpnyY3BMELOexgRb"></div>
                        </div>
                        <p id="captcha-error" style="font-size:10px;margin-top: -17px;margin-left: -11px;color:#ed4337;display: none;">
                          Please verify that you are not a robot
                        </p>
                    </div>
                    <button type="submit" id="btn_login" class="btn btn-sm" name="btn_login" style="margin-left: -12px;font-size: 18px;margin-top: -11px;">Login</button>
                </form>
               <!-- Forgot password link -->
               <div class="forgot-password" style="margin-top: 1.9px; margin-left: 82px;">
                    <a href="forgot_password.php?pages=forgot_password">Forgot Password?</a>
                </div>

                <!-- For Switching Login Form-->
                <!-- <div style="margin-top: -20px;margin-left: 195px;">
                    <a href="../login.php?pages=login" style="color:white;">User Login</a>
                </div> -->

                <!-- Horizontal rule -->
                <hr style="border: 1px solid gray; margin-top: 7px;">
                
                
                <!-- Error attempts message -->
                <p style="font-size:12px;color:white;margin-top: -17px;">
                    <?php echo $error_attempts; ?>
                </p>
                <!-- Error attempts message -->
                <p style="font-size:12px;color:white;margin-top: -9px;">
                    <?php echo $error_attempts; ?>
                </p>
                <?php if ($error_attempts): ?>
                <!-- Error Modal structure -->
                <div id="error-modal" class="modal" style="display: block;">
                    <div class="modal-content" style="margin-left:479px;">
                        <span class="modal-title">Error</span>
                        <p><?php echo $error_attempts; ?></p>
                        <button id="error-ok-button" class="btn-ok">OK</button>
                    </div>
                </div>     
                <?php endif; ?>
                <!-- Error message modal and JavaScript for dismiss -->
                <?php if ($error): ?>
                <!-- Error Modal structure -->
                <div id="error-modal1" class="modal1" style="display: block;">
                    <div class="modal-content1" style="margin-left:479px;">
                        <span class="modal-title1">Error</span>
                        <p>Invalid account. Please try again.</p>
                        <button id="error-ok-button1" class="btn-ok1">OK</button>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Success message and JavaScript for redirection -->
                <?php if ($login_success): ?>
                <!-- Modal structure -->
                <div id="success-modal2" class="modal2" style="display: block;">
                    <div class="modal-content2" style="margin-left:479px;">
                        <span class="modal-title2">Success</span>
                        <p>Login Successfully!</p>
                        <button id="ok-button2" class="btn-ok2">OK</button>
                    </div>
                </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div>
                <h3>We use cookies!</h3>
                <p>
                    This website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent.
                </p>
            </div>
            <div class="buttons">
                <button class="button" id="acceptBtn">I Agree</button>
                <button class="button" id="customizeBtn">Customize</button>
            </div>
        </div>
        <!-- Modal Structure -->
        <div id="cookieSettingsModal" class="modal" style="display:none;">
            <div id="s-inr" class="modal-content3">
                <div id="s-hdr">
                    <h2 id="s-ttl">Cookies Settings</h2>
                    <span id="s-c-bn" class="close-button" aria-label="Close">&times;</span>
                </div>
                <div id="s-bl">
                    <div class="scrollable">
                    <div class="desc">
                        <h4 style="font-size: 18px;">Cookies Usage</h4>
                        <p>We use cookies to ensure the basic functionalities of the website and to improve your online experience. You can choose to opt in or out of each category whenever you want.</p>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl">Functionality Cookies</h5>
                            <label class="b-tg">
                                <input type="checkbox" id="functionalityCookies" class="c-tgl" checked>
                                <span class="c-tg" aria-hidden="true">
                                    <span class="on-i"></span>
                                    <span class="off-i"></span>
                                </span>
                            </label>
                        </div>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl">Security Cookies</h5>
                            <label class="b-tg">
                                <input type="checkbox" id="securityCookies" class="c-tgl" checked>
                                <span class="c-tg" aria-hidden="true">
                                    <span class="on-i"></span>
                                    <span class="off-i"></span>
                                </span>
                            </label>
                        </div>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl">Personalization Cookies</h5>
                            <label class="b-tg">
                                <input type="checkbox" id="personalizationCookies" class="c-tgl">
                                <span class="c-tg" aria-hidden="true">
                                    <span class="on-i"></span>
                                    <span class="off-i"></span>
                                </span>
                            </label>
                        </div>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl">Ad Cookies</h5>
                            <label class="b-tg">
                                <input type="checkbox" id="adCookies" class="c-tgl">
                                <span class="c-tg" aria-hidden="true">
                                    <span class="on-i"></span>
                                    <span class="off-i"></span>
                                </span>
                            </label>
                        </div>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl">Ad User Data</h5>
                            <label class="b-tg">
                                <input type="checkbox" id="adUserData" class="c-tgl">
                                <span class="c-tg" aria-hidden="true">
                                    <span class="on-i"></span>
                                    <span class="off-i"></span>
                                </span>
                            </label>
                        </div>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl">Ad Personalization</h5>
                            <label class="b-tg">
                                <input type="checkbox" id="adPersonalization" class="c-tgl">
                                <span class="c-tg" aria-hidden="true">
                                    <span class="on-i"></span>
                                    <span class="off-i"></span>
                                </span>
                            </label>
                        </div>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl">Analytics Cookies</h5>
                            <label class="b-tg">
                                <input type="checkbox" id="analyticsCookies" class="c-tgl">
                                <span class="c-tg" aria-hidden="true">
                                    <span class="on-i"></span>
                                    <span class="off-i"></span>
                                </span>
                            </label>
                        </div>
                    </div>
        
                    <div class="c-bl">
                        <div class="title">
                            <h5 class="b-tl" style="margin-left: -8px;">More Information</h5>
                        </div>
                        <div class="desc">
                            <p>For any queries in relation to my policy on cookies and your choices, please contact us.</p>
                        </div>
                    </div>
                </div>
                <div id="s-bns">
                    <button id="acceptall" class="c-bn">Accept All</button>
                    <button id="acceptnecessary" class="c-bn1" style="margin-right: 143px;width: 153px;">Accept Necessary</button>
                    <button id="saveSettings" class="c-bn1" style="margin-right: -18px;width: 113px;">Save Settings</button>
                </div>
            </div>
        </div> 
    </div>
</div>
<script>
// Get modal elements
const modal = document.getElementById('cookieSettingsModal');
const customizeBtn = document.getElementById('customizeBtn');
const closeButton = document.querySelector('.close-button');
const saveSettingsButton = document.getElementById('saveSettings');

// Function to open the modal
customizeBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

// Function to close the modal
closeButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Optional: Save settings functionality
saveSettingsButton.addEventListener('click', () => {
    const functionalityEnabled = document.getElementById('functionalityCookies').checked;
    const securityEnabled = document.getElementById('securityCookies').checked;
    const personalizationEnabled = document.getElementById('personalizationCookies').checked;
    const adEnabled = document.getElementById('adCookies').checked;
    const adUserDataEnabled = document.getElementById('adUserData').checked;
    const adPersonalizationEnabled = document.getElementById('adPersonalization').checked;
    const analyticsEnabled = document.getElementById('analyticsCookies').checked;

    console.log(`Functionality Cookies Enabled: ${functionalityEnabled}`);
    console.log(`Security Cookies Enabled: ${securityEnabled}`);
    console.log(`Personalization Cookies Enabled: ${personalizationEnabled}`);
    console.log(`Ad Cookies Enabled: ${adEnabled}`);
    console.log(`Ad User Data Enabled: ${adUserDataEnabled}`);
    console.log(`Ad Personalization Enabled: ${adPersonalizationEnabled}`);
    console.log(`Analytics Cookies Enabled: ${analyticsEnabled}`);

    // Save preferences logic here
    modal.style.display = 'none'; // Close modal after saving
});

// Close modal if clicked outside of it
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});


  
    const cookieBox = document.querySelector(".wrapper"),
    buttons = document.querySelectorAll(".button");

    const executeCodes = () => {
      // If cookie contains codinglab, it will be returned and below code will not run
      if (document.cookie.includes("codinglab")) return;
      cookieBox.classList.add("show");
    
      buttons.forEach((button) => {
        button.addEventListener("click", () => {
          // Check if the button clicked is not the "Customize" button
          if (button.id === "acceptBtn") {
            // Hide cookie box and set the cookie
            cookieBox.classList.remove("show");
            document.cookie = "cookieBy=codinglab; max-age=" + 60 * 60 * 24 * 30;
          }
          // If the button clicked is "Customize," do not hide the cookie box
        });
      });
    };
    
    executeCodes();

  
   //executeCodes function will be called on webpage load
   window.addEventListener("load", executeCodes);

document.addEventListener("DOMContentLoaded", function() {
    const acceptAllButton = document.getElementById("acceptall");
    const acceptNecessaryButton = document.getElementById("acceptnecessary");
    const saveSettingsButton = document.getElementById("saveSettings");

    const functionalityCookies = document.getElementById("functionalityCookies");
    const securityCookies = document.getElementById("securityCookies");
    const personalizationCookies = document.getElementById("personalizationCookies");
    const adCookies = document.getElementById("adCookies");
    const adUserData = document.getElementById("adUserData");
    const adPersonalization = document.getElementById("adPersonalization");
    const analyticsCookies = document.getElementById("analyticsCookies");

    // Accept All button functionality
    acceptAllButton.addEventListener("click", function() {
        functionalityCookies.checked = true;
        securityCookies.checked = true;
        personalizationCookies.checked = true;
        adCookies.checked = true;
        adUserData.checked = true;
        adPersonalization.checked = true;
        analyticsCookies.checked = true;
    });

    // Accept Necessary button functionality
    acceptNecessaryButton.addEventListener("click", function() {
        functionalityCookies.checked = true;
        securityCookies.checked = true;
        personalizationCookies.checked = false;
        adCookies.checked = false;
        adUserData.checked = false;
        adPersonalization.checked = false;
        analyticsCookies.checked = false;
    });

    // Save Settings button functionality
    saveSettingsButton.addEventListener("click", function() {
        const settings = {
            functionality: functionalityCookies.checked,
            security: securityCookies.checked,
            personalization: personalizationCookies.checked,
            ads: adCookies.checked,
            adUserData: adUserData.checked,
            adPersonalization: adPersonalization.checked,
            analytics: analyticsCookies.checked,
        };
        console.log("Settings saved:", settings);
        // Close modal here if needed
    });
});
</script>
<script>
     document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("error-ok-button").addEventListener("click", function() {
          document.getElementById("error-modal").style.display = 'none';
      });
    });

  function validateRecaptcha() {
    var response = grecaptcha.getResponse();
    if (response.length === 0) {
        document.getElementById("captcha-error").style.display = "block";
        return false; // Prevent form submission
    }
    return true; // Allow form submission
  }

  document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("error-ok-button").addEventListener("click", function() {
          document.getElementById("error-modal").style.display = 'none';
      });
  });

  // Wait for the DOM to load
  document.addEventListener("DOMContentLoaded", function() {
      // Attach a click event to the OK button
      document.getElementById("error-ok-button1").addEventListener("click", function() {
          // Close the error modal when OK is clicked
          document.getElementById("error-modal1").style.display = 'none';
      });
  });
  // Wait for the DOM to load
  document.addEventListener("DOMContentLoaded", function() {
      // Attach a click event to the OK button
      document.getElementById("ok-button2").addEventListener("click", function() {
          // Redirect to the dashboard after the OK button is clicked
          window.location.href = '../admin/dashboard/dashboard.php?page=dashboard';
      });
  });
  function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        const iconElement = icon.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            iconElement.classList.remove('fa-eye');
            iconElement.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            iconElement.classList.remove('fa-eye-slash');
            iconElement.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>