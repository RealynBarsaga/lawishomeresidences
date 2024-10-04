<?php
session_start();
include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
function send_password_reset($get_name,$get_email,$token)
{
   //Server settings
   //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    
   $mail->isSMTP();                                            
   $mail->SMTPAuth   = true;                                   

   $mail->Host       = 'smtp.example.com';                     
   $mail->Username   = 'gilbertsevillejo@gmail.com';                     
   $mail->Password   = "***";   

   $mail->SMTPSecure = "tls";            
   $mail->Port       = 587;

   //Recipients
   $mail->setFrom('gilbertsevillejo@gmail.com',$get_name);
   $mail->addAddress($get_email); 
               
   $email->isHTML(true);
   $email->Subject = "Reset Password Notificaton";

   $email_template = "
           <h2>HELLO</h2>
           <h3>You are receiving this email because we received a password reset request for your account.</h3>
           <br/><br/>
           <a href='http://localhost/lawishomerecidences/regiter-login-with-verification/password-change.php?token=$token&email=$get_email'> Click Me</a>
   ";

   $email->Body = $email_template;
   $email->send();
}

if(isset($_POST['password_reset_link']))
{
   $email = mysqli_real_escape_string($con, $_POST['email']);
   $token = md5(rand());

   $check_email = "SELECT email FROM tbluser WHERE email = '$email' LIMIT 1";
   $check_email_run = mysqli_query($con, $check_email);


   if(mysqli_num_rows($check_email_run) > 0)
   {
      $row = mysqli_fetch_array($check_email_run);
      $get_name = $row['username'];
      $get_email = $row['email'];

      $update_token = "UPDATE tbluser SET verify_token = '$token' WHERE email = '$get_email' LIMIT 1";
      $check_token_run = mysqli_query($con, $update_token);

      if($check_token_run)
      {
        send_password_reset($get_name,$get_email,$token);
        $_SESSION['status'] = "We e-mailed you a password reset link.";
        header("Location: forgot_password.php?pages=forgot_password");
        exit(0);
      }
      else
      {
        $_SESSION['status'] = "Something went wrong. #1";
        header("Location: forgot_password.php?pages=forgot_password");
        exit(0);
      }
   }
   else
   {
      $_SESSION['status'] = "No Email Found";
      header("Location: forgot_password.php?pages=forgot_password");
      exit(0);
   } 
}
?>