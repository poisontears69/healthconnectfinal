<?php
require_once 'database.php'; // Database connection
$db = new Database();

$clinic_id = $_GET['clinic_id'] ?? null;

// Fetch clinic details
$sql_clinic = "SELECT * FROM clinics WHERE clinic_id = :clinic_id";
$clinic = $db->query($sql_clinic, ['clinic_id' => $clinic_id])->fetch(PDO::FETCH_ASSOC);

// Ensure clinic details are available
if (!$clinic) {
    die("Clinic not found.");
}

// Fetch posts
$sql_posts = "SELECT cp.*, u.first_name, u.last_name FROM clinic_posts cp 
              JOIN users u ON cp.user_id = u.user_id
              WHERE cp.clinic_id = :clinic_id 
              ORDER BY cp.created_at DESC";
$posts = $db->query($sql_posts, ['clinic_id' => $clinic_id])->fetchAll(PDO::FETCH_ASSOC);

// Fetch photos
$sql_photos = "SELECT * FROM clinic_photos WHERE clinic_id = :clinic_id ORDER BY uploaded_at DESC";
$photos = $db->query($sql_photos, ['clinic_id' => $clinic_id])->fetchAll(PDO::FETCH_ASSOC);

// Fetch clinic settings
$sql_settings = "SELECT * FROM clinic_settings WHERE clinic_id = :clinic_id";
$settings = $db->query($sql_settings, ['clinic_id' => $clinic_id])->fetch(PDO::FETCH_ASSOC);

// Parse open days
$open_days = [];
if ($settings) {
    foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
        if ($settings[$day . '_open']) {
            $open_days[] = ucfirst($day);
        }
    }
}

$open_time = $settings['open_time'] ?? '09:00:00';
$close_time = $settings['close_time'] ?? '18:00:00';
$allow_online_consultation = $settings['allow_online_consultation'] ?? 0;
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


    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+63 9171384217</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="search_for_clinics.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Back<i class="fa fa-arrow-left ms-3"></i></a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
            </div>
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Health Connect</h1>
        </a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: url('<?php echo htmlspecialchars($clinic['clinic_cover_photo'] ?: 'default-cover.jpg'); ?>') center center / cover no-repeat;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown"><?php echo htmlspecialchars($clinic['clinic_name']); ?></h1>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Clinic Details Start -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="fw-bold text-primary">About the Clinic</h2>
                <p class="text-dark fw-medium"><p><?php echo htmlspecialchars($clinic['description']); ?></p>
            </div>
            <div class="col-lg-4">
                <div class="bg-light rounded p-4 shadow-sm">
                    <h3 class="fw-bold text-primary">Operating Hours</h3>
                    <p class="text-dark fw-medium"><strong>Open Days:</strong> <?php echo $open_days ? implode(', ', $open_days) : 'Closed'; ?></p>
                    <p class="text-dark fw-medium"><strong>Hours:</strong> <?php echo date('h:i A', strtotime($open_time)) . ' - ' . date('h:i A', strtotime($close_time)); ?></p>
                    <p class="text-dark fw-medium"><strong>Online Consultation:</strong> <?php echo $allow_online_consultation ? 'Available' : 'Not Available'; ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Clinic Details End -->



    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Tunga-tunga, Maasin City, Southern Leyte, 6600</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+63 171384217</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>healthcontactconnect@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Newsletter</h5>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Health Connect</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">Matthew</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


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
