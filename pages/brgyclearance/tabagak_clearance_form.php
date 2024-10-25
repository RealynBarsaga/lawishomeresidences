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

        /* General body margin */
        body {
            margin: 20px; /* Adds margin around the entire body */
        }

        /* Margin for the header section */
        .header-section {
            margin-bottom: 30px; /* Adds margin below the header */
        }

        /* Main content margin */
        .main-content {
            margin-left: 30px;
            margin-right: 30px;
        }
        .header-section{
            margin-left: 40px;
            margin-right: 40px;
        }
    </style>
    <script>
        window.print();
        onafterprint = () => {
            window.location.href = "brgyclearance.php?page=brgyclearance";
        }
    </script>
</head>
<body class="skin-black">
    <?php
    session_start(); // Start session management

    // Set timezone to Manila
    date_default_timezone_set('Asia/Manila');

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
    <div class="header-section" style="background: white; padding: 20px 0; margin-bottom: 30px;">
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
            <br>
            <hr style="border: 1px solid black; width: 264%; margin: 1px auto; position: relative; right: 210px;" />
        </div>
        <center>
            <p style="margin-left: 65px;">OFFICE OF THE BARANGAY CAPTAIN<p>
        </center>
    </div>
    <div class="col-xs-4 col-sm-3 col-md-2" style="background: white; margin-left: -82px; position: relative; left: 85px; padding: 10px;">
        <img src="../../img/lg.png" style="width:70%; height:120px;" />
    </div>
    </div>
    <div class="col-xs-4 col-sm-6 col-md-3" style="margin-top: 20px;background: white; margin-left:50px; border: 1px solid black;width: 200px;">
        <div style="margin-top:40px; text-align: center; word-wrap: break-word;font-size:15px;">
            <p style="font-size:12px;font-weight: 600;">BARANGAY OFFICIALS</p>
            <?php
            $off_barangay = $_SESSION["barangay"] ?? "";

                $qry = mysqli_query($con,"SELECT * from tblbrgyofficial WHERE barangay = '$off_barangay'");
                while($row=mysqli_fetch_array($qry)){
                    if($row['sPosition'] == "Captain"){
                        echo '
                            <p>
                            <b style="font-size:10.5px; color: dodgerblue !important;">HON. '.strtoupper($row['completeName']).'</b><br>
                            <span style="font-size:12px;">Punong Barangay</span>
                            </p><br>
                        ';
                    }elseif($row['sPosition'] == "Kagawad"){
                        echo '
                        <b style="font-size:10.5px;  color: dodgerblue !important;">HON. '.strtoupper($row['completeName']).'</b><br>
                        <span style="font-size:12px;">Barangay Kagawad</span><br>
                        ';
                    }elseif($row['sPosition'] == "SK Chairman/Chairperson"){
                        echo '
                        <b style="font-size:10.5px; color: dodgerblue !important;">HON. '.strtoupper($row['completeName']).'</b><br>
                        <span style="font-size:12px;">SK Chairman</span><br>
                        ';
                    }elseif($row['sPosition'] == "Secretary"){
                        echo '
                        <b style="font-size:10.5px; color: dodgerblue !important;">'.strtoupper($row['completeName']).'</b><br>
                        <span style="font-size:12px;">Barangay Secretary</span><br>
                        ';
                    }elseif($row['sPosition'] == "Treasurer"){
                        echo '
                        <b style="font-size:10.5px; color: dodgerblue !important;">'.strtoupper($row['completeName']).'</b><br>
                        <span style="font-size:12px;">Barangay Treasurer</span><br>
                        ';
                    }
                }
            ?>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content col-xs-12 col-md-12">
        <br><br>
        <p class="text-center" style="font-size: 20px; font-weight: bold; margin-left: 100px;margin-top:-665px;">
            <b style="font-size: 28px;">BARANGAY CLEARANCE</b>
        </p>
        <p style="margin-left: 220px;font-size: 12px; font-family: 'Courier New', Courier;">TO WHOM IT MAY CONCERN:</p>
        <p style="margin-left: 220px; margin-right: 60px; text-indent:15px; text-align: justify;font-family: 'Courier New', Courier;">
            &nbsp;&nbsp;This is to certify according to the records available in this barangay the applicant whose details are indicated
            below,
        </p>
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
            
            // Query to select clearance details along with age, bdate, purok, and civil status from tblclearance
            $squery = mysqli_query($con, "SELECT * FROM tblclearance WHERE name = '$name' AND barangay = '$off_barangay' LIMIT 1");
            
            // Loop through clearance details
            if ($row = mysqli_fetch_array($squery)) {
                // Prepare data for display
                $fullName = strtoupper($row['Name']);
                $address = "" . $row['purok'] . "," . $row['barangay'] . ",Madridejos,Cebu";

                // Convert birth date to DateTime and format it
                $birthDate = new DateTime($row['bdate']);
                $formattedBirthDate = $birthDate->format('F j, Y'); // e.g., January 1, 2000

                $birthPlace = "" . $row['bplace'] . ""; // Assuming birth place is always Madridejos, adjust as needed
                $civilStatus = $row['civilstatus']; // Adjust according to your database field for civil status
            
                // Display information
                echo "<p style='font-family: \"Courier New\"; font-size: 15px;'>
                        <strong  style='margin-left: 210px;'&nbsp;>&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {$fullName}</strong><br>
                        <strong style='margin-left: 210px;'>&nbsp;Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {$address}</strong><br>
                        <strong style='margin-left: 210px;'>&nbsp;Birth Date&nbsp;&nbsp;&nbsp;: {$formattedBirthDate}</strong><br>
                        <strong style='margin-left: 210px;'>&nbsp;Birth Place&nbsp;&nbsp;: {$birthPlace}</strong><br>
                        <strong style='margin-left: 210px;'>&nbsp;Civil Status&nbsp;: {$civilStatus}</strong>
                      </p>";
            }
        ?>
        <p style="margin-left: 220px; margin-right: 60px; text-indent:15px; text-align: justify; font-family: 'Courier New', Courier;">
            &nbsp;&nbsp;Is known to me of good moral character based on our Barangay records has not been charged of any crime neither imputed of any social misdemeanor.
        </p>
        <p style="margin-left: 220px; margin-right: 60px; text-indent:15px; text-align: justify; font-family: 'Courier New', Courier; margin-top:-10px;">
            &nbsp;&nbsp;This Barangay Clearance is being issued upon the request of above-mentioned applicant in connection with his/her.
        </p>
        </p>
        <p>
            <?php
            $name = $_GET['resident'];
            $squery = mysqli_query($con, "SELECT * FROM tblclearance WHERE name = '$name' LIMIT 1");

            if ($row = mysqli_fetch_array($squery)) {
                echo "<p style='margin-left: 220px;font-family: \"Courier New\"; font-size: 17px;'>PURPOSES: <strong>" . strtoupper($row['purpose']) . "</strong></p>";
            }
            ?> 
        </p>
        <p style="margin-left: 220px; margin-right: 60px; font-family: 'Courier New', Courier; text-indent:15px; text-align: justify;">
            <?php
                $name = $_GET['resident'];
                $squery = mysqli_query($con, "SELECT * FROM tblclearance WHERE name = '$name' LIMIT 1");
            
                if ($row = mysqli_fetch_array($squery)) {
                    $dateRecorded = $row['dateRecorded'];
                    echo "<span style='font-family: \"Courier New\", Courier, monospace; text-align: justify; font-size: 15px;'>
                        &nbsp;&nbsp;Given this <strong>". date('j', strtotime($dateRecorded)) ."<sup>". date('S', strtotime($dateRecorded)) ."</sup></strong> day of 
                        <strong>" . date('F', strtotime($dateRecorded)) . "</strong>, <strong>" . date('Y', strtotime($dateRecorded)) . "</strong> 
                        at <strong>" . $row['barangay'] . ", Madridejos</strong><strong> Cebu, Philippines.</strong>
                    </span>";
                }
            ?>
        </p>
        <p style="margin-top: 70px;">
        <?php
          // Assuming a session has already been started somewhere in your code
          $off_barangay = $_SESSION["barangay"] ?? ""; // Get barangay from session

          $squery = mysqli_query($con, "SELECT * FROM tblclearance WHERE name = '$name' AND barangay = '$off_barangay' LIMIT 1");

          if ($row = mysqli_fetch_array($squery)) {
            echo '
              <strong style="margin-top: -350px;font-size: 17px; margin-left: 370px;">'.strtoupper($row['Name']).'</strong><br>
              <hr style="border: 0.1px solid black; width: 27%; margin-left: 361px;margin-top: -15px;" />
              <p style="margin-left: 390px;margin-top: -20px;">Signature of Applicant</p>
            ';
          }
        ?>
    </p>
    </div> 
    <div class="col-xs-offset-6 col-xs-5 col-md-offset-6 col-md-4" style="top: 30px;">
        <p style="text-align: center;">
            <?php
                // Assuming a session has already been started somewhere in your code
                $off_barangay = $_SESSION["barangay"] ?? ""; // Get barangay from session
                // Adjust the query to filter by barangay
                $qry = mysqli_query($con, "SELECT * FROM tblbrgyofficial WHERE barangay = '$off_barangay'");
                while($row = mysqli_fetch_array($qry)){
                    if($row['sPosition'] == "Captain"){
                        echo '
                        <strong style="font-size: 17px; margin-left: 40px;">HON.'.strtoupper($row['completeName']).'</strong>
                        <hr style="border: 0.1px solid black; width: 85%; margin-left: 40px;margin-top: -15px;"/>
                        <p style="margin-left: 110px; margin-top: -20px;">Punong Barangay</p>
                        ';
                    }
                }
            ?>
        </p>
    </div>
    <div class="col-md-5 col-xs-4" style="float:left;margin-top: -150px;margin-left: 250px;">
        <div style="height:100px; width:130px; border: 1px solid black;">
            <center><span style="text-align: center; line-height: 160px;">Right Thumb Mark</span></center>
        </div>
    </div>
</body>
</html>