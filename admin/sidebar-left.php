<style>
.skin-black .left-side {
  background: rgb(51, 51, 51);
}
</style>
<?php
	echo '
	<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                            <li>
                                <a href="../../admin/dashboard/dashboard.php?page=dashboard">
                                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="../../admin/officials/officials.php?page=officials">
                                    <i class="fa fa-user"></i> <span>Madridejos Officials</span>
                                </a>
                            </li>
                            <li>
                                <a href="../../admin/staff/staff.php?page=staff">
                                    <i class="fa fa-university"></i> <span>List Of Barangay</span>
                                </a>
                            </li>
                            <li>
                                <a href="../householdlist/householdlist.php?page=householdlist">
                                    <i class="fa fa-users"></i> <span>List Of Household</span>
                                </a>
                            </li>
                             <li>
                                <a href="../permit/permit.php?page=permit">
                                    <i class="fa fa-file"></i> <span>Permit</span>
                                </a>
                            </li>
                            <li>
                                <a href="../generatereports/generatereports.php">
                                    <i class="fa fa-paper-plane"></i> <span>Generated Reports</span>
                                </a>
                            </li>                  
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
	';
?>