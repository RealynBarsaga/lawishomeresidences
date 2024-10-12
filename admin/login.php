<!DOCTYPE html>
<html lang="en">
<html>
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
    <link href="../css/style2.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            <div style="text-align:center;margin-top:-20px;">
                    <img src="../img/lg.png" style="height:60px;"/>
                    <h3 class="panel-title">
                        <strong>
                            Madridejos Home Residence Management System
                        </strong>
                    </h3>
                    <br>
                    <center>
                       <h7 style="margin-bottom: -42px;font-family: Georgia, serif;font-size: 18px;text-align: center;margin-bottom: -42px; color: white;">ADMIN LOGIN</h7>
                    </center>
                </div>
                <form role="form" method="post">
                <div class="form-group" style="border-radius:1px; border: 25px;">
                    <label for="txt_username" style="color:#fff;margin-left: -8px;margin-top: 22px;font-weight: lighter;">Email</label>
                    <input type="email" class="form-control" name="txt_username"
                           placeholder="e.g., jose@gmail.com" required value="<?php echo $username_or_email ?>" style="margin-top: -3px;width: 300px;margin-left: -11px;">

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
                </div>
                    <button type="submit" class="btn btn-sm" name="btn_login" style="font-size: 18px;margin-top: 13px;">Login</button>
                </form>
               <!-- Forgot password link -->
               <div class="forgot-password" style="margin-top: 1.9px;margin-left: 140px;">
                    <a href="admin/forgot_password.php?pages=forgot_password">Forgotten Password?</a>
                </div>

                <!-- For Switching Login Form-->
                <!-- <div style="margin-top: -20px;margin-left: 195px;">
                    <a href="../login.php?pages=login" style="color:white;">User Login</a>
                </div> -->

                <!-- Horizontal rule -->
                <hr style="border: 1px solid gray; margin-top: 7px;">
                
                
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
</div>
<script>
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
          window.location.href = 'admin/dashboard/dashboard.php?page=dashboard';
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