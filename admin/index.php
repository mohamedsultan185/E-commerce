<?php
session_start();
if (!(isset($_SESSION['admin_username']))) { 
    header("location:auth/login.php");
    exit(); // Make sure to exit after redirecting to prevent further execution of the script.
}
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/bar.php'; ?>
<?php include_once 'includes/footer.php'; ?>
