<?php
// view_all_notifications.php
include "connection.php"; // Ensure you include your database connection

// Fetch notifications from the database
$squery = mysqli_query($con, "SELECT * FROM tbllogs ORDER BY logdate DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madridejos Home Residence Management System</title>
    <link rel="icon" type="x-icon" href="../img/lg.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 40%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 3px;
        }
        .notification {
            font-size: 13px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            color: #333;
            padding: 7px;
            display: block;
            max-width: 100%;
            border-radius: 4px;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
        }
        .footer a {
            text-decoration: none;
            color: #007bff;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Notifications</h1>
        <ul>
            <?php
            while($notif = mysqli_fetch_assoc($squery)){
                $user = isset($notif['user']) ? htmlspecialchars($notif['user']) : 'Unknown user';
                $action = isset($notif['action']) ? htmlspecialchars($notif['action']) : 'No action available';
                
                $message = sprintf(
                    '<span class="notification">%s <br> %s.</span>',
                    $user,
                    $action
                );

                echo '<li>' . $message . '</li>';
            }
            ?>
        </ul>
        <div class="footer">
            <a href="dashboard/dashboard.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
