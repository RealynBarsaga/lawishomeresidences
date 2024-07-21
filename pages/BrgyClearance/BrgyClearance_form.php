<!DOCTYPE html>
<html id="clearance">
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
    </style>
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
    $_SESSION['clr'] = $_GET['clearance']; // Store clearance ID in session
    include('../head_css.php'); // Include CSS file
    include "../connection.php"; // Include database connection
    ?>
    
    <!-- Header Section -->
    <div style="background: black;">
        <div class="col-xs-4 col-sm-3 col-md-2" style="background: white; margin-right: -124px;">
            <img src="../../img/tb.png" style="width:70%; height:120px;" />
        </div>
        <div class="col-xs-7 col-sm-6 col-md-8" style="background: white;">
            <div class="pull-left" style="font-size: 16px; margin-left: 100px; font-family: 'Courier New', Courier;">
                <center>
                    Republic of the Philippines<br>
                    Region VII-Northern Visayas<br>
                    Province of Cebu<br>
                    Municipality of Madridejos
                    <b>
                        <p style="font-size: 25px; font-family: 'Courier New', Courier;">BARANGAY TABAGAK</p>
                    </b>
                </center>
                <hr style="border: 1px solid black; width: 300%; margin: 1px auto; position: relative; right: 250px;" />
            </div>
        </div>
        <div class="col-xs-4 col-sm-3 col-md-2" style="background: white; margin-left: -82px; position: relative; left: 75px;">
            <img src="../../img/lg.png" style="width:70%; height:120px;" />
        </div>
    </div>  

    <div class="pull-right">
        <?php
        // Uncomment and adjust the code if needed to display resident's image
        /*
        $qry1 = mysqli_query($con, "SELECT * FROM tblresident r LEFT JOIN tblclearance c ON c.residentid = r.id WHERE residentid = '".$_GET['resident']."' AND clearanceNo = '".$_GET['clearance']."'");
        while ($row1 = mysqli_fetch_array($qry1)) {
            echo '<img src="../resident/image/'.basename($row1['image']).'" style="width:160px; height:160px;" />';
        }
        */
        ?>
    </div>

    <!-- Main Content -->
    <div class="col-xs-12 col-md-12">
        <br><br>
        <p class="text-center" style="font-size: 20px; font-weight: bold;">
            OFFICE OF THE BARANGAY CAPTAIN<br>
            <b style="font-size: 28px;">BARANGAY CLEARANCE</b>
        </p>
        <p style="font-size: 12px; font-family: 'Courier New', Courier;">TO WHOM IT MAY CONCERN:</p>
        <p style="text-indent:40px; text-align: justify;">
            <?php
            $id = $_GET['resident'];
            // Query to select resident details
            $squery = mysqli_query($con, "SELECT * FROM tblresident WHERE id = $id LIMIT 1");

            // Loop through resident details
            while ($row = mysqli_fetch_array($squery)) {
                // Generate certificate text
                echo "<p style='font-family: \"Courier New\"; text-indent:80px; text-align: justify;'>
                This is to certify that <strong><u>" . strtoupper($row['fname'] . ' ' . $row['mname'] . '. ' . $row['lname']) . "</u></strong>, <strong><u>" . 
                $row['age'] . "</u></strong> years of age, born on <strong><u>" . $row['bdate'] . "</u></strong>, a native of <strong><u>Madridejos</u></strong>. 
                <span style='font-family: \"Courier New\";'>and presently residing at Purok " . $row['purok'] . " Barangay " . $row['barangay'] . ", Madridejos, Cebu.</span></p>";
            }
            ?> 
        </p>
        <br>
        <p style="font-size: 12px; font-family: 'Courier New', Courier;">
            <?php
            $resident_id = $_GET['resident']; // Make sure this is set
            $squery = mysqli_query($con, "SELECT * FROM tblclearance WHERE residentid = '$resident_id' LIMIT 1") or die('Error: ' . mysqli_error($con));

            // Loop through clearance details
            while ($row = mysqli_fetch_array($squery)) {
                // Generate certificate text
                echo "<p style='font-family: \"Courier New\"; font-size: 17px;'> Purpose: ".strtoupper($row['purpose']) . "</p>";
            }
            ?> 
        </p>
        <br>
        <p style="text-indent:40px; text-align: justify;">
            <?php
            $squery = mysqli_query($con, "SELECT * FROM tblresident WHERE id = $id LIMIT 1");

            // Loop through resident details
            while ($row = mysqli_fetch_array($squery)) {
                echo "<p style='font-family: \"Courier New\"; text-indent:80px; text-align: justify;'>
                This certification is issued upon the request of <strong><u>" . strtoupper($row['fname'] . ' ' . $row['mname'] . '. ' . $row['lname']) . "</u></strong>
                 <span style='font-family: \"Courier New\";'>for any legal purpose it may serve.</span></p>";
            }
            ?> 
        </p>
        <br>
        <p style="font-size: 17px; font-family: 'Courier New', Courier;"><b>Remarks:</b></p>
    </div> 

    <div class="col-xs-offset-6 col-xs-5 col-md-offset-6 col-md-4" style="top: 350px;">
    <p style="text-align: center;">
        <strong style="font-size: 18px; margin-right: 5px;">HON. REXIBER  VILLACERAN</strong><br>
        <hr style="border: 1px solid black; width: 90%; margin: 1px auto;" />
        <span style="margin-left: 100px;">Punong Barangay</span>
    </p>
</div>


    <!-- Print Button -->
    <button style="margin-top: 37px; position: absolute; right: 60px;" class="btn btn-primary noprint" id="printpagebutton" onclick="PrintElem('#clearance')">Print</button>

    <script>
        // Function to print the document
        function PrintElem(elem) {
            window.print(); // Trigger print dialog
        }
    </script>
</body>
</html>
