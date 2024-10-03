<?php
session_start();

// Destroy all sessions
session_unset();
session_destroy();

// Redirect to the homepage
header("Location: /");
exit();
?>