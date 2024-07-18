<?php
	echo '
	<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    ';
                        echo '
                    <ul class="sidebar-menu">
                            <li>
                                <a href="../../admin/dashboard/dashboard.php">
                                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="../../admin/officials/officials.php">
                                    <i class="fa fa-users"></i> <span>Madridejos Officials</span>
                                </a>
                            </li>
                            <li>
                                <a href="../../admin/staff/staff.php">
                                    <i class="fa fa-university"></i> <span>List Of Barangay</span>
                                </a>
                            </li>
                             <li>
                                <a href="../permit/permit.php">
                                    <i class="fa fa-file"></i> <span>Permit</span>
                                </a>
                            </li>
                            <li>
                                <a href="../generatereports/generatereports.php">
                                    <i class="fa fa-paper-plane"></i> <span>Generated Reports</span>
                                </a>
                            </li>
                            <li>
                                <a href="../../admin/logs/logs.php">
                                    <i class="fa fa-history"></i> <span>Logs</span>
                                </a>
                            </li>                             
                    </ul>';
                echo '
                </section>
                <!-- /.sidebar -->
            </aside>
	';
?>