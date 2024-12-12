<?php
include_once 'database.php';

class Stats {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getDoctorCount() {
        $query = "SELECT COUNT(*) FROM users WHERE roleType = '1'";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['COUNT(*)'];
    }


    public function getMedicalStaffCount() {
        $query = "SELECT COUNT(*) FROM users WHERE roleType = '0'";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['COUNT(*)'];
    }

    public function getPatientCount() {
        $query = "SELECT COUNT(*) FROM patients";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['COUNT(*)'];
    }
}

// Fetching the counts
$stats = new Stats();
$doctorCount = $stats->getDoctorCount();
$medicalStaffCount = $stats->getMedicalStaffCount();
$patientCount = $stats->getPatientCount();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Klinik - Clinic Website Template</title>
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
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Health Connect</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Service</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                        <a href="feature.html" class="dropdown-item">Feature</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Appointment<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Header Start -->
<div class="container-fluid header bg-primary p-0 mb-5">
    <div class="row g-0 align-items-center flex-column-reverse flex-lg-row">
        <div class="col-lg-6 p-5 wow fadeIn" data-wow-delay="0.1s">
            <h1 class="display-4 text-white mb-5">Good Health Is The Root Of All Happiness</h1>
            <div class="row g-4">
                <div class="col-sm-4">
                    <div class="border-start border-light ps-4">
                        <h2 class="text-white mb-1" data-toggle="counter-up"><?php echo $doctorCount; ?></h2>
                        <p class="text-light mb-0">Expert Doctors</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="border-start border-light ps-4">
                        <h2 class="text-white mb-1" data-toggle="counter-up"><?php echo $medicalStaffCount; ?></h2>
                        <p class="text-light mb-0">Medical Staff</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="border-start border-light ps-4">
                        <h2 class="text-white mb-1" data-toggle="counter-up"><?php echo $patientCount; ?></h2>
                        <p class="text-light mb-0">Total Patients</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
            <div class="owl-carousel header-carousel">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-1.jpg" alt="">
                    <div class="owl-carousel-text">
                        <h1 class="display-1 text-white mb-0">Cardiology</h1>
                    </div>
                </div>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                    <div class="owl-carousel-text">
                        <h1 class="display-1 text-white mb-0">Neurology</h1>
                    </div>
                </div>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-3.jpg" alt="">
                    <div class="owl-carousel-text">
                        <h1 class="display-1 text-white mb-0">Pulmonary</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->



    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column">
                        <img class="img-fluid rounded w-75 align-self-end" src="img/about-1.jpg" alt="">
                        <img class="img-fluid rounded w-50 bg-white pt-3 pe-3" src="img/about-2.jpg" alt="" style="margin-top: -25%;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <p class="d-inline-block border rounded-pill py-1 px-4">About Us</p>
                    <h1 class="mb-4">Why You Should Trust Us? Get to Know About Us!</h1>
                    <p>At Health Connect, we are committed to providing the best healthcare services for you. With our team of highly qualified professionals, you can trust us to handle your medical needs with the utmost care and expertise. We offer a platform that helps you book appointments with experienced doctors for both online and walk-in consultations, ensuring you get the best care, when and where you need it.</p>
                    <p class="mb-4">Our doctors and medical staff are dedicated to making healthcare accessible to all. We are proud of our long-standing commitment to quality care, supported by the latest medical technology and research. Whether you are visiting us for a routine check-up or a specialized consultation, we make sure every patient is treated with respect and compassion.</p>
                    <p><i class="far fa-check-circle text-primary me-3"></i>Quality health care for all patients</p>
                    <p><i class="far fa-check-circle text-primary me-3"></i>Only qualified doctors with proven experience</p>
                    <p><i class="far fa-check-circle text-primary me-3"></i>Medical research professionals ensuring cutting-edge treatments</p>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->



    <!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="d-inline-block border rounded-pill py-1 px-4">Services</p>
            <h1>Health Care Solutions</h1>
        </div>
        <div class="row g-4">
            <!-- Cardiology -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-heartbeat text-primary fs-4"></i>
                    </div>
                    <h4 class="mb-3">Cardiology</h4>
                    <p class="mb-4">Our cardiology specialists provide comprehensive heart care, from diagnosis to advanced treatments, ensuring the health of your heart with cutting-edge medical technology.</p>
                    <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
                </div>
            </div>

            <!-- Pulmonary -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-x-ray text-primary fs-4"></i>
                    </div>
                    <h4 class="mb-3">Pulmonary</h4>
                    <p class="mb-4">We offer expert pulmonary care for respiratory diseases, ensuring that patients receive the best diagnosis and treatment for lung conditions such as asthma, COPD, and more.</p>
                    <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
                </div>
            </div>

            <!-- Neurology -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-brain text-primary fs-4"></i>
                    </div>
                    <h4 class="mb-3">Neurology</h4>
                    <p class="mb-4">Our neurology department provides state-of-the-art treatment for various neurological disorders, including epilepsy, stroke, and chronic pain, helping patients regain their quality of life.</p>
                    <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
                </div>
            </div>

            <!-- Orthopedics -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-wheelchair text-primary fs-4"></i>
                    </div>
                    <h4 class="mb-3">Orthopedics</h4>
                    <p class="mb-4">Our orthopedic specialists treat bone, joint, and muscle disorders. From sports injuries to joint replacement surgeries, we ensure your recovery with the latest treatments and techniques.</p>
                    <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
                </div>
            </div>

            <!-- Dental Surgery -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-tooth text-primary fs-4"></i>
                    </div>
                    <h4 class="mb-3">Dental Surgery</h4>
                    <p class="mb-4">Our dental surgery team provides expert care for a range of oral issues, including tooth extractions, implants, and restorative procedures to help you achieve a healthy smile.</p>
                    <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
                </div>
            </div>

            <!-- Laboratory -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item bg-light rounded h-100 p-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                        <i class="fa fa-vials text-primary fs-4"></i>
                    </div>
                    <h4 class="mb-3">Laboratory</h4>
                    <p class="mb-4">Our fully equipped laboratory offers accurate testing for a variety of medical conditions. With fast results and high-quality service, we support your treatment and diagnosis needs.</p>
                    <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->



    <!-- Feature Start -->
    <div class="container-fluid bg-primary overflow-hidden my-5 px-lg-0">
        <div class="container feature px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 feature-text py-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="p-lg-5 ps-lg-0">
                        <p class="d-inline-block border rounded-pill text-light py-1 px-4">Features</p>
                        <h1 class="text-white mb-4">Why Choose Us</h1>
                        <p class="text-white mb-4 pb-2">Our platform offers convenient and efficient healthcare solutions. Book appointments for both walk-ins and online consultations with experienced doctors. Enjoy easy access to clinics in your area and timely notifications for all your appointments.</p>
                        <div class="row g-4">
                            <!-- Search Clinics in your area -->
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                        <i class="fa fa-search text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">Search Clinics</p>
                                        <h5 class="text-white mb-0">In Your Area</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- Book appointments and Notifications -->
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                        <i class="fa fa-calendar-check text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">Book Appointments</p>
                                        <h5 class="text-white mb-0">& Notifications</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- Online Consultation -->
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                        <i class="fa fa-video text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">Online</p>
                                        <h5 class="text-white mb-0">Consultation</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- 24/7 Support -->
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                                        <i class="fa fa-headset text-primary"></i>
                                    </div>
                                    <div class="ms-4">
                                        <p class="text-white mb-2">24/7</p>
                                        <h5 class="text-white mb-0">Support</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="img/feature.jpg" style="object-fit: cover;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->



    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block border rounded-pill py-1 px-4">Developers</p>
                <h1>Our Experienced Developers</h1>
            </div>
            <div class="row g-4">
                <!-- Developer 1 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item position-relative rounded overflow-hidden">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/team-1.jpg" alt="Developer 1">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h5>Matthew Rey Tagoy</h5>
                            <p class="text-primary">Frontend Developer</p>
                            <div class="team-social text-center">
                                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Developer 2 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item position-relative rounded overflow-hidden">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/team-2.jpg" alt="Developer 2">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h5>Karylle Fernandez</h5>
                            <p class="text-primary">Backend Developer</p>
                            <div class="team-social text-center">
                                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Developer 3 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item position-relative rounded overflow-hidden">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/team-3.jpg" alt="Developer 3">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h5>Diserie Becong</h5>
                            <p class="text-primary">UI/UX Designer</p>
                            <div class="team-social text-center">
                                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Developer 4 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item position-relative rounded overflow-hidden">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/team-4.jpg" alt="Developer 4">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h5>Ralph Gaviola</h5>
                            <p class="text-primary">Project Manager</p>
                            <div class="team-social text-center">
                                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Developer 5 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item position-relative rounded overflow-hidden">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/team-2.jpg" alt="Developer 5">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h5>Maria Angela</h5>
                            <p class="text-primary">QA Specialist</p>
                            <div class="team-social text-center">
                                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Developer 6 -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item position-relative rounded overflow-hidden">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="img/team-1.jpg" alt="Developer 6">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h5>Rio Labor</h5>
                            <p class="text-primary">Database Administrator</p>
                            <div class="team-social text-center">
                                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->



    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block border rounded-pill py-1 px-4">Testimonial</p>
                <h1>What Our Patients Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light rounded-circle p-2 mx-auto mb-4" src="img/testimonial-1.jpg" style="width: 100px; height: 100px;">
                    <div class="testimonial-text rounded text-center p-4">
                        <p>"I had an amazing experience at Health Connect. The doctors were very professional and attentive. They thoroughly explained the treatment options available to me, and I felt confident throughout the entire process. I am now recovering well and couldn't be happier with the care I received!"</p>
                        <h5 class="mb-1">John Doe</h5>
                        <span class="fst-italic">Engineer</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light rounded-circle p-2 mx-auto mb-4" src="img/testimonial-2.jpg" style="width: 100px; height: 100px;">
                    <div class="testimonial-text rounded text-center p-4">
                        <p>"The staff at Health Connect was incredibly helpful and caring. From scheduling my appointment to the actual consultation, everything was seamless. I felt heard and valued as a patient. I would highly recommend their services to anyone seeking quality healthcare!"</p>
                        <h5 class="mb-1">Jane Smith</h5>
                        <span class="fst-italic">Teacher</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="img-fluid bg-light rounded-circle p-2 mx-auto mb-4" src="img/testimonial-3.jpg" style="width: 100px; height: 100px;">
                    <div class="testimonial-text rounded text-center p-4">
                        <p>"I’ve had the privilege of receiving care from Health Connect for both my routine checkups and a major health issue. The team has always been incredibly knowledgeable and friendly. The best part is that I can now book online appointments, making healthcare even more convenient!"</p>
                        <h5 class="mb-1">Alice Johnson</h5>
                        <span class="fst-italic">Designer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->



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