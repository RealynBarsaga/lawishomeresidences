<?php
session_start();

// Destroy all sessions
session_unset();
session_destroy();

// Redirect to the /admin page (without query parameters)
header("Location: /admin");
exit();
?>