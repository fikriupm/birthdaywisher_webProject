<?php
session_start();

// Destroy the session
session_destroy();

// Set cache control headers
// header("Cache-Control: no-cache, no-store, must-revalidate");
// header("Pragma: no-cache");
// header("Expires: 0");
// header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// header("Cache-Control: private, no-cache, no-store, proxy-revalidate, no-transform");

// Redirect to the login page
// unset($_SESSION['name']);
header("Location: pagelogin.php");
exit();
?>
