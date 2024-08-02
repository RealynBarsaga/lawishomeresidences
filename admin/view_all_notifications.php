<?php
include "connection.php"; // Ensure you include your database connection

// Handle deletion of selected notifications
if (isset($_POST['delete_selected'])) {
    $ids_to_delete = $_POST['notification_ids'];
    if (!empty($ids_to_delete)) {
        $ids_to_delete = array_map('intval', $ids_to_delete); // Sanitize IDs
        $ids_string = implode(',', $ids_to_delete);
        $delete_query = mysqli_query($con, "DELETE FROM tbllogs WHERE id IN ($ids_string)");
        if ($delete_query) {
            header("Location: view_all_notifications.php");
            exit();
        } else {
            echo "Error deleting notifications.";
        }
    }
}

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
            position: relative;
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
            position: relative;
        }
        .menu-button {
            background: none;
            border: none;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 16px;
            color: #333;
        }
        .menu-button:after {
            content: "\22EE";
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 30px;
            right: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .dropdown-menu a {
            display: block;
            padding: 5px 10px;
            color: #333;
            text-decoration: none;
        }
        .dropdown-menu a:hover {
            background-color: #f4f4f4;
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
        .select-all-container {
            margin-bottom: 20px;
            text-align: right;
        }
        .select-all {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }
    </style>
    <script>
        function toggleMenu(id) {
            var menu = document.getElementById("menu-" + id);
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        }

        document.addEventListener('click', function(e) {
            var menus = document.querySelectorAll('.dropdown-menu');
            menus.forEach(function(menu) {
                if (!menu.contains(e.target) && !e.target.classList.contains('menu-button')) {
                    menu.style.display = 'none';
                }
            });
        });

        function toggleSelectAll(source) {
            checkboxes = document.querySelectorAll('input[name="notification_ids[]"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>All Notifications</h1>
        <form method="post" action="view_all_notifications.php">
            <div class="select-all-container">
                <input type="checkbox" onclick="toggleSelectAll(this)"> Select All
            </div>
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

                    echo '<li><input type="checkbox" name="notification_ids[]" value="'.$notif['id'].'"> ' . $message . '
                            <button class="menu-button" onclick="toggleMenu('.$notif['id'].')"></button>
                            <div id="menu-'.$notif['id'].'" class="dropdown-menu">
                                <a href="view_all_notifications.php?delete_id='.$notif['id'].'">Delete</a>
                            </div>
                          </li>';
                }
                ?>
            </ul>
            <div>
                <button type="submit" name="delete_selected" class="delete-button">Delete Selected</button>
            </div>
        </form>
        <div class="footer">
            <a href="dashboard/dashboard.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
