<?php
// Create a new Database object
$db = new Database();

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Query the database to check if the user has any clinics
$sql = "SELECT * FROM clinics WHERE user_id = :user_id LIMIT 1";
$stmt = $db->query($sql, ['user_id' => $user_id]);

// Fetch the clinic data if it exists
$clinics = $db->query($sql, ['user_id' => $user_id])->fetchAll(PDO::FETCH_ASSOC);
?>
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
            </div>
        </div>
    </div>
    <!-- Topbar End -->

<div class="container mt-5">
    <h2 class="text-center mb-4">Your Clinics</h2>

    <!-- Display session messages (if any) -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="container-xxl py-5">
        <div class="container">
            <!-- Section for Clinics List
            <div class="row g-4" id="clinicContainer">
                <div class="col-lg-6 col-md-8 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item position-relative rounded overflow-hidden">
                        <div class="overflow-hidden">
                            <img class="img-fluid" style="height: 500px; object-fit: cover; width: 100%;" src="<?php echo htmlspecialchars('img/carousel-1.jpg'); ?>" alt="<?php echo htmlspecialchars($clinic['clinic_name']); ?>">
                        </div>
                        <div class="team-text bg-light text-center p-4">
                            <h5 class="fw-bold">Create or Join a Clinic</h5>
                            <a href="create_clinic.php" class="btn btn-primary rounded-pill mb-2">Create a Clinic</a>
                            <a href="join_clinic.php" class="btn btn-secondary rounded-pill mb-2">Join a Clinic</a>
                        </div>
                    </div>
                </div> -->
                <?php foreach ($clinics as $clinic): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp clinic-item" data-wow-delay="0.3s">
                        <a href="clinic_details.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" class="text-decoration-none">
                            <div class="team-item position-relative rounded overflow-hidden" style="cursor: pointer;">
                                <div class="overflow-hidden">
                                    <img class="img-fluid" style="height: 500px; object-fit: cover; width: 100%;" 
                                         src="<?php echo htmlspecialchars($clinic['clinic_cover_photo'] ?: 'default-cover.jpg'); ?>" 
                                         alt="<?php echo htmlspecialchars($clinic['clinic_name']); ?>">
                                </div>
                                <div class="team-text bg-light text-center p-4">
                                    <h5 class="fw-bold"><?php echo htmlspecialchars($clinic['clinic_name']); ?></h5>
                                    <p class="text-primary">Specialization: <?php echo htmlspecialchars($clinic['specialization']); ?></p>
                                    <p><?php echo htmlspecialchars(substr($clinic['description'], 0, 100)); ?>...</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>