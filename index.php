<?php
session_start();
if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])) { 
    header("location:auth/login.php");
    exit(); // Make sure to exit after redirecting to prevent further execution of the script.
}
?>

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sultan store</title>
    <!-- to use icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- connect with css file  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<?php include_once 'includes/top-bar.php';?>

</html>
