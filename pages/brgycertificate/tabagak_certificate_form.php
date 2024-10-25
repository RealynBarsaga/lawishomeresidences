<!DOCTYPE html>
<html>
<head>
    <title>Madridejos Home Residence Management System</title>
    <link rel="icon" type="x-icon" href="../../img/lg.png">
    <style>
        /* Styles for print media */
        @media print {
            .noprint {
                visibility: hidden; /* Hide elements with class 'noprint' when printing */
            }
        }
        @page {
            size: auto;
            margin: 4mm; /* Set margin for printed page */
        }

        /* General body margin */
        body {
            margin: 20px; /* Adds margin around the entire body */
        }

        /* Main container with side margins */
        .container {
            margin: 0 50px; /* Adds left and right margins */
        }

        /* Header section margin */
        .header-section {
            margin: 0 40px 30px 40px; /* Adds left and right margin */
        }

        /* Main content margin */
        .main-content {
            padding: 0 30px; /* Adds padding inside the content */
        }
        /* Styles for the footer section */
        .footer-section {
            margin-left: 40px; /* Add left margin for the footer */
            margin-right: 40px; /* Add right margin for the footer */
        }
    </style>
    <script>
        window.print();
        onafterprint = () => {
            window.location.href = "brgycertificate.php?page=brgycertificate";
        } 
    </script>
</head>
<body class="skin-black">
    <?php
    session_start(); // Start session management

    // Redirect to login if the user role is not set
    if (!isset($_SESSION['role'])) {
        header("Location: ../../login.php");
        exit;
    }

    ob_start(); // Start output buffering
    include('../head_css.php'); // Include CSS file
    include "../connection.php"; // Include database connection
    ?>

    <!-- Main container -->
    <div class="container">

        <!-- Header Section -->
        <div class="header-section" style="background: white;">
            <br>
            <div class="col-xs-4 col-sm-3 col-md-2" style="background: white; margin-right: -124px; padding: 10px;">
                <img src="../../admin/staff/logo/<?= $_SESSION['logo'] ?>" style="width:70%; height:120px;" />
            </div>
            <div class="col-xs-7 col-sm-6 col-md-8" style="background: white; padding: 10px;">
                <div class="pull-left" style="font-size: 16px; margin-left: 100px; font-family: 'Courier New', Courier;">
                    <center>
                        Republic of the Philippines<br>
                        Province of Cebu<br>
                        Municipality of Madridejos
                        <b>
                            <p style="font-size: 22px; font-family: 'Courier New', Courier; text-transform: uppercase;color: dodgerblue !important;">Barangay <?= $_SESSION['barangay'] ?></p>
                        </b>
                    </center>
                    <p style="margin-left:-5px;">OFFICE OF THE PUNONG BARANGAY</p>
                    <hr style="border: 1px solid black; width: 260%; margin: 1px auto; position: relative; right: 227px;" />
                </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2" style="background: white; margin-left: -82px; position: relative; left: 85px; padding: 10px;">
                <img src="../../img/lg.png" style="width:70%; height:120px;" />
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content col-xs-12 col-md-12">
            <p class="text-center" style="font-size: 20px; font-weight: bold; margin-left: 10px;">
                <b style="font-size: 28px;">BARANGAY CERTIFICATION</b>
            </p>
            <br>
            <p style="font-size: 12px; font-family: 'Courier New', Courier;">TO WHOM IT MAY CONCERN:</p>
            <br>
            <p>
            <?php
            // Get barangay from session
            $off_barangay = $_SESSION["barangay"] ?? "";
            // Get the resident's name from the URL parameter
            $name = $_GET['resident'];

            // Ensure proper escaping to avoid SQL injection
            $name = mysqli_real_escape_string($con, $name);
            $off_barangay = mysqli_real_escape_string($con, $off_barangay);

            // Query to select clearance details along with age, bdate, and purok from tbltabagak
            $squery = mysqli_query($con, "SELECT * FROM tblcertificate WHERE name = '$name' AND barangay = '$off_barangay' LIMIT 1");
            
            // Loop through clearance details
            if ($row = mysqli_fetch_array($squery)) {
                echo "<p style='font-family: \"Courier New\", Courier, monospace; text-align: justify; font-size: 16px; margin: 10px 3;'>
                &nbsp;&nbsp;&nbsp;This is to certify that <strong>" . strtoupper($row['Name']) . "</strong>, 
                <strong>" . $row['age'] . " years old</strong>, and bonafide resident of <strong>Purok " . $row['purok'] . ", " . $row['barangay'] . ", Madridejos, Cebu</strong> and personally known to me as a good person and a law-abiding citizen of this Barangay.
                </p>";
            }
            ?>
            </p>
            <br>
            <p>
                <?php
                $off_barangay = $_SESSION["barangay"] ?? ""; // Get barangay from session
                $squery = mysqli_query($con, "SELECT * FROM tblcertificate WHERE name = '$name' AND barangay = '$off_barangay' LIMIT 1");

                if ($row = mysqli_fetch_array($squery)) {
                    echo "<p style='font-family: \"Courier New\", Courier, monospace; text-align: justify; font-size: 16px;margin: 10px 5px;'>
                    &nbsp;&nbsp;&nbsp;This certification is being issued upon the request of aboved-named person for <strong>" . $row['purpose'] . "</strong> purposes it may serve him/her best.</p>";
                }
                ?> 
            </p>
            <br>
            <br>
            <p style="margin-left:-12px; font-size: 16px; font-family: 'Courier New', Courier; text-indent:40px; text-align: justify;margin: 10px 50px 10px 3px;">
                <?php
                    $name = $_GET['resident'];
                    $squery = mysqli_query($con, "SELECT * FROM tblcertificate WHERE name = '$name' LIMIT 1");
                
                    if ($row = mysqli_fetch_array($squery)) {
                        $dateRecorded = $row['dateRecorded'];
                        echo "<span style='font-family: \"Courier New\", Courier, monospace; text-align: justify; font-size: 15px;'>
                            Given this day <strong style='color: dodgerblue !important;'>". date('j', strtotime($dateRecorded)) ."<sup style='color: dodgerblue !important;'>". date('S', strtotime($dateRecorded)) ."</sup></strong> of 
                            <strong style='color: dodgerblue !important;'>" . date('F', strtotime($dateRecorded)) . "</strong>, <strong style='color: dodgerblue !important;'>" . date('Y', strtotime($dateRecorded)) . "</strong> 
                            at <strong style='color: dodgerblue !important;'>" . $row['barangay'] . ", Madridejos</strong><strong style='color: dodgerblue !important;'> Cebu, Philippines.</strong>
                        </span>";
                    }
                ?>
            </p>
        </div> 
        <div class="col-xs-offset-6 col-xs-5 col-md-offset-6 col-md-4" style="top: 250px;">
        <i>Approved by:</i>
        <br>
        <br>
            <p style="text-align: center;">
                <?php
                    // Assuming a session has already been started somewhere in your code
                    $off_barangay = $_SESSION["barangay"] ?? ""; // Get barangay from session
                    // Adjust the query to filter by barangay
                    $qry = mysqli_query($con, "SELECT * FROM tblbrgyofficial WHERE barangay = '$off_barangay'");
                    while($row = mysqli_fetch_array($qry)){
                        if($row['sPosition'] == "Captain"){
                            echo '
                            <strong style="font-size: 18px; margin-right: 3px;">HON.'.strtoupper($row['completeName']).'</strong><br>
                            <hr style="border: 1px solid black; width: 90%; margin: 1px auto;margin-top: -15px;" />
                            <span style="margin-left: 85px;">Punong Barangay</span>
                            ';
                        }
                    }
                ?>
            </p>
        </div>
    </div> <!-- End container -->
</body>
</html>