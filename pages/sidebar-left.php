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
                                <a href="../household/household.php">
                                    <i class="fa fa-home"></i> <span>Household</span>
                                </a>
                            </li>
                            <li>
                                <a href="../resident/resident.php">
                                    <i class="fa fa-users"></i> <span>Resident</span>
                                </a>
                            </li>
                            <li>
                                <a href="../BrgyClearance/BrgyClearance.php">
                                    <i class="fa fa-file"></i> <span>Barangay Clearance</span>
                                </a>
                            </li>
                            <li>
                                <a href="../CertOfRes/CertOfRes.php">
                                    <i class="fa fa-file"></i> <span>Certificate Of Residency</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-file"></i> <span>Certificate Of Indigency</span>
                                </a>
                            </li>
                        </ul>';
                echo '
                </section>
                <!-- /.sidebar -->
            </aside>
	';
?>