<!-- index_user.php -->
<?php 
session_start();
include('database.php'); // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if the user is not logged in
    exit();
}
// Include header and necessary parts dynamically
include('header_user.php'); 
include('sidenav_user.php'); 
include('main_user.php'); 
include('footer_user.php'); 
?>
