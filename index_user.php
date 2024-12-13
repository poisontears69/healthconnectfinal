<!-- index_user.php -->
<?php 
session_start();
include('database.php'); // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if the user is not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Health Connect</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <a href="?page=clinics"><i class="fas fa-clinic-medical me-2"></i>Clinics</a>
            <a href="?page=patients"><i class="fas fa-user-friends me-2"></i>Patients</a>
            <a href="?page=settings"><i class="fas fa-cog me-2"></i>Settings</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </div>
        <!-- Main Content Area -->
        <div class="content flex-grow-1">
            <button class="toggle-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
            <div>
                <?php
                // Dynamic Content
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];

                    // Prevent direct access to arbitrary files
                    if ($page == 'clinics') {
                        include('clinics.php');
                    } elseif ($page == 'patients') {
                        include('patients.php');
                    } elseif ($page == 'settings') {
                        include('settings_user.php');
                    } else {
                        echo "<p>Page not found.</p>";
                    }
                } else {
                    echo "<p>Welcome to your dashboard. Choose an option from the sidebar.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        // Toggle Sidebar for Small Screens
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
