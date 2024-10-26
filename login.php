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
        include "pages/connection.php";

        // Retrieve input values
        $username_or_email = htmlspecialchars(stripslashes(trim($_POST['txt_username'])));
        $password = htmlspecialchars(stripslashes(trim($_POST['txt_password'])));

        // Initialize login attempts
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        // Modify the query to allow login using either username or email
        $stmt = $con->prepare("SELECT * FROM tblstaff WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username_or_email, $username_or_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $numrow_staff = $result->num_rows;

        if ($numrow_staff > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Reset login attempts upon successful login
                $_SESSION['login_attempts'] = 0;

                $_SESSION['role'] = "Staff";
                $_SESSION['staff'] = $row['name'];
                $_SESSION['userid'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION["barangay"] = $row["name"];
                $_SESSION['logo'] = $row['logo'];
                
                // Set login success flag to true
                $login_success = true;
            } else {
                // Increment login attempts
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] < $max_attempts) {
                    $error = true;
                }
            }
        } else {
            // Increment login attempts for invalid username
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
    }
}

// Optional: Clear the error after showing it to avoid repetition on refresh
if ($error || $error_attempts) {
    $error_message = "Invalid account. Please try again.";
} else {
    $error_message = ""; // Reset error message if login attempt is successful
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
    <link href="css/style1.css" rel="stylesheet" type="text/css"/>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="script.js" defer></script>
</head>
<style>
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
</style>
<body class="skin-black">
<div class="container" style="margin-top: -5px;">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel">
            <div class="panel-body">
            <div style="text-align:center;margin-top:-28px;">
                    <img src="img/lg.png" style="height:60px;"/>
                    <h3 class="panel-title">
                        <strong>
                            Madridejos Home Residence Management System
                        </strong>
                    </h3>
                    <br>
                    <center style="margin-top: -5px;">
                        <h7 style="margin-bottom: -42px;font-family: Georgia, serif;font-size: 18px;text-align: center;margin-bottom: -42px; color: white;">USER LOGIN</h7>
                    </center>
                </div>
                <form role="form" method="post" onsubmit="return validateRecaptcha()">
                    <div class="form-group" style="border-radius:1px; border: 25px;">
                        <label for="txt_username" style="color:#fff;margin-left: -8px;font-weight: lighter;">Email</label>
                        <input type="email" class="form-control" name="txt_username"
                               placeholder="e.g., jose@gmail.com" required value="<?php echo $username_or_email ?>" style="margin-top: -5px;width: 300px;margin-left: -11px;">

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
                        <p id="captcha-error" style="font-size:10px;margin-top: -17px;margin-left: -11px;color: white; display: none;">
                          Please verify that you are not a robot
                        </p>
                    </div>
                    <button type="submit" id="btn_login" class="btn btn-sm" name="btn_login" style="margin-left: -13px;font-size: 18px;margin-top: -11px;">Login</button>
                </form>
                <!-- Forgot password link -->
                <div class="forgot-password" style="margin-top: 1.9px;margin-left: 140px;">
                    <a href="forgot_password.php?pages=forgot_password">Forgotten Password?</a>
                </div>
                <!-- For Switching Login Form-->
                <!-- <div style="margin-top: -20px;margin-left: 195px;">
                    <a href="admin/login.php?pages=login" style="color:white;">Admin Login</a>
                </div> -->

                <!-- Horizontal rule -->
                <hr style="border: 1px solid gray; margin-top: 7px;">
                
                
                <!-- Error attempts message -->
                <p style="font-size:12px;color:white;margin-top: -17px;">
                    <?php echo $error_attempts; ?>
                </p>
                <div class="wrapper">
                    <header>
                      <i class="bx bx-cookie"></i>
                      <h2 style="font-size:25px;color:#f90404b3;">Cookies Consent</h2>
                    </header>
                    <div class="data">
                      <p>We use cookies and similar technologies (including third party cookies from our partners) to enable essential site functionality, enhance site navigation, analyze site usage, personalization, and assist in our advertising and marketing efforts and provide social media features, for which we may share cookie data with our third-party partners. You can update or manage your settings at any time. To learn more, see our<a href="#"> Privacy Policy</a></p>
                    </div>
                    <div class="buttons">
                      <button class="button" id="acceptBtn">Accept All Cookies</button>
                      <button class="button" id="declineBtn">Reject All</button>
                    </div>
                </div>
                <!-- <div style="margin-top: -20px;margin-left: 164px;">
                    <a href="admin/login.php?pages=login" style="color:white;">Admin Login</a>
                </div> -->
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
<script>
   $(document).on('click', '#btn_login', function(){
       var response = g-recaptcha.getResponse();
       alert(response);
   })   
   const cookieBox = document.querySelector(".wrapper"),
   buttons = document.querySelectorAll(".button");
   
   const executeCodes = () => {
     //if cookie contains codinglab it will be returned and below of this code will not run
     if (document.cookie.includes("codinglab")) return;
     cookieBox.classList.add("show");
   
     buttons.forEach((button) => {
       button.addEventListener("click", () => {
         cookieBox.classList.remove("show");
   
         //if button has acceptBtn id
         if (button.id == "acceptBtn") {
           //set cookies for 1 month. 60 = 1 min, 60 = 1 hours, 24 = 1 day, 30 = 30 days
           document.cookie = "cookieBy= codinglab; max-age=" + 60 * 60 * 24 * 30;
         }
       });
     });
   };
   
   //executeCodes function will be called on webpage load
   window.addEventListener("load", executeCodes);

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
          window.location.href = 'pages/dashboard/dashboard.php?page=dashboard';
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