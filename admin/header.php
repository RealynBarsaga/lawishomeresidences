<style>
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
    .notification {
        font-size: 13px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        color: #333;
        padding: 7px;
        display: block;
        max-width: 300px;
        border-radius: 4px;
        word-wrap: break-word;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .notification:hover {
        background-color: #e0e0e0;
    }
</style>

<?php
// Database connection (assuming you have already connected $con)
session_start();

// Fetch the total number of notifications
$countQuery = mysqli_query($con, "SELECT COUNT(*) AS count FROM tbllogs");
$countResult = mysqli_fetch_assoc($countQuery);
$notificationCount = $countResult['count'];

// Change the Font if needed
echo '<header class="header">
        <a href="../../admin/dashboard/dashboard.php" class="logo" style="font-size: 13px; font-family: Source Sans Pro, sans-serif;">
            Madridejos Home Residence
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i><span>Administrator <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header bg-light-blue">
                                <p>Administrator</p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#editProfileModal">Change Account</a>
                                </div>
                                <div class="pull-right">
                                    <a href="../../admin/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="navbar-right" style="margin-left: 90px;">
                <ul class="nav navbar-nav">
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-bell"></i><span class="label label-warning">'.$notificationCount.'</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have '.$notificationCount.' notifications</li>
                            <li>
                                <ul class="menu">';
                                
                                // Fetch notifications from the database
                                $squery = mysqli_query($con, "SELECT * FROM tbllogs ORDER BY logdate DESC");
                                while($notif = mysqli_fetch_assoc($squery)){
                                    $user = isset($notif['user']) ? htmlspecialchars($notif['user']) : 'Unknown user';
                                    $action = isset($notif['action']) ? htmlspecialchars($notif['action']) : 'No action available';
                                    
                                    echo '<li style="margin-bottom: 2px;">
                                            <span class="notification">'.$user.'<br>'.$action.'</span>
                                          </li>';
                                }
                                
                                echo '</ul>
                            </li>
                            <li class="footer"><a href="../view_all_notifications.php">View all</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>';
?>

<div id="editProfileModal" class="modal fade">
    <form method="post">
        <div class="modal-dialog modal-sm" style="width:300px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Change Account</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                        <?php
                        // Securely fetch user data
                        $stmt = $con->prepare("SELECT * FROM tbluser WHERE id = ?");
                        $stmt->bind_param("i", $_SESSION['userid']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        
                        echo '
                            <div class="form-group">
                                <label>Username:</label>
                                <input name="txt_username" id="txt_username" class="form-control input-sm" type="text" value="'.htmlspecialchars($row['username']).'" />
                            </div>
                            <div class="form-group">
                                <label>Password:</label>
                                <input name="txt_password" id="txt_password" class="form-control input-sm" type="password" value="'.htmlspecialchars($row['password']).'"/>
                            </div>';
                        ?>    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
                    <input type="submit" class="btn btn-primary btn-sm" id="btn_saveeditProfile" name="btn_saveeditProfile" value="Save"/>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
if(isset($_POST['btn_saveeditProfile'])){
    // Securely update user data
    $username = htmlspecialchars($_POST['txt_username']);
    $password = htmlspecialchars($_POST['txt_password']);

    $stmt = $con->prepare("UPDATE tbluser SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $password, $_SESSION['userid']);
    $updadmin = $stmt->execute();

    if($updadmin){
        header("Location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}
?>
