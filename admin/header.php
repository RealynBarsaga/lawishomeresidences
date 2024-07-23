<?php
//Change the Font if needed
echo  '<header class="header">
        <a href="../../admin/dashboard/dashboard.php" class="logo" style="font-size: 13px; font-family: Source Sans Pro, sans-serif;">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            Madridejos Home Residence
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i><span>Administrator <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <p>
                                    Administrator
                                </p>
                            </li>
                            <!-- Menu Body --> 
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#editProfileModal">Change Account</a>
                                </div>
                                <div class="pull-right">
                                    <a href="../../admin/login.php" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
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
                        $user = mysqli_query($con,"SELECT * from tbluser where id = '".$_SESSION['userid']."' ");
                        while($row = mysqli_fetch_array($user)){
                            echo '
                                <div class="form-group">
                                    <label>Username:</label>
                                    <input name="txt_username" id="txt_username" class="form-control input-sm" type="text" value="'.$row['username'].'" />
                                </div>
                                <div class="form-group">
                                    <label>Password:</label>
                                    <input name="txt_password" id="txt_password" class="form-control input-sm" type="password"  value="'.$row['password'].'"/>
                                </div>';
                        }
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
    $username = $_POST['txt_username'];
    $password = $_POST['txt_password'];

    $updadmin = mysqli_query($con,"UPDATE tbluser set username = '$username', password = '$password' where id = '".$_SESSION['userid']."' ");
    if($updadmin == true){
        header ("location: ".$_SERVER['REQUEST_URI']);
    }
}
?>
