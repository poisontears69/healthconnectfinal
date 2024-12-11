<?php
require_once 'database.php';
$db = new Database();

// Fetch all clinics (for initial load)
$sql_clinics = "SELECT * FROM clinics ORDER BY created_at DESC";
$clinics = $db->query($sql_clinics);

// Check if query execution was successful and data was retrieved
if ($clinics !== false && $clinics->rowCount() > 0) {
    $clinics = $clinics->fetchAll(PDO::FETCH_ASSOC);
} else {
    $clinics = [];  // Ensure $clinics is always an array, even if no data is found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="index_patient.css">
</head>
<body>

    <?php include 'navbar_patient.php'; ?>

    <!-- Hero Section with Carousel -->
    <section class="hero">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/pic1.jpg" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/pic2.jpg" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/pic3.jpg" class="d-block w-100" alt="Slide 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2>About Us</h2>
            <p class="lead">Our platform connects patients with the best clinics nearby, offering a seamless experience for booking and managing appointments.</p>
        </div>
    </section>

    <!-- Tutorial Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center">How to Use Our Platform</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="tutorial1.jpg" class="card-img-top" alt="Step 1">
                        <div class="card-body">
                            <h5 class="card-title">Step 1</h5>
                            <p class="card-text">Search for clinics based on location or specialization.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="tutorial2.jpg" class="card-img-top" alt="Step 2">
                        <div class="card-body">
                            <h5 class="card-title">Step 2</h5>
                            <p class="card-text">View clinic details and available services.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="tutorial3.jpg" class="card-img-top" alt="Step 3">
                        <div class="card-body">
                            <h5 class="card-title">Step 3</h5>
                            <p class="card-text">Book an appointment with ease.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search and Clinics Section -->
    <section class="py-5">
        <div class="container">
            <!-- Search Bar -->
            <div class="search-bar mb-4">
                <input type="text" id="searchQuery" class="form-control" placeholder="Search clinics by name, location, or specialization" />
            </div>
            <h2 class="text-center mb-4">Available Clinics</h2>
            <div class="row g-4" id="clinicResults">
                <?php if (!empty($clinics)): ?>
                    <?php foreach ($clinics as $clinic): ?>
                        <div class="col-md-4">
                            <div class="card clinic-card">
                                <img src="<?php echo htmlspecialchars($clinic['clinic_cover_photo'] ?: 'default-cover.jpg'); ?>" class="cover-photo" alt="Cover Photo">
                                <img src="<?php echo htmlspecialchars($clinic['clinic_profile_photo'] ?: 'default-profile.jpg'); ?>" class="profile-photo" alt="Profile Photo">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($clinic['clinic_name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($clinic['description'], 0, 100)); ?></p>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($clinic['address'], 0, 100)); ?></p>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($clinic['specialization'], 0, 100)); ?></p>
                                    <a href="view_clinic.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No clinics available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
