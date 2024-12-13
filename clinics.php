<?php
// Create a new Database object
$db = new Database();

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Query the database to check if the user has any clinics
$sql = "SELECT * FROM clinics WHERE user_id = :user_id LIMIT 1";
$stmt = $db->query($sql, ['user_id' => $user_id]);

// Fetch the clinic data if it exists
$clinic = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Clinics</h1>
    </div>
</div>
<!-- Page Header End -->

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

    <div class="row justify-content-center">
        <?php if (!$clinic): ?>
            <!-- If the user has no clinics, show a clickable card to create or join a clinic -->
            <div class="col-md-6">
                <div class="card text-center border-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">No Clinic Created</h5>
                        <p class="card-text">You have not created any clinics yet.</p>
                        <a href="create_clinic.php" class="btn btn-primary rounded-pill mb-2">Create a Clinic</a>
                        <a href="join_clinic.php" class="btn btn-secondary rounded-pill">Join a Clinic</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- If the user has a clinic, display it -->
            <div class="col-md-6">
                <div class="card clinic-card border-light shadow-sm">
                    <!-- Display the cover photo -->
                    <img src="<?php echo htmlspecialchars($clinic['clinic_cover_photo']); ?>" 
                         class="card-img-top cover-photo rounded-top" alt="Cover Photo">

                    <!-- Display the profile photo -->
                    <div class="text-center mt-n5">
                        <img src="<?php echo htmlspecialchars($clinic['clinic_profile_photo']); ?>" 
                             class="profile-photo rounded-circle border" alt="Profile Photo">
                    </div>

                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($clinic['clinic_name']); ?></h5>
                        <p class="text-muted"><?php echo htmlspecialchars($clinic['clinic_code']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars($clinic['specialization']); ?></p>
                        <a href="clinic_details.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" 
                           class="btn btn-info rounded-pill">View Clinic</a>
                    </div>
                    <div class="text-end pe-3 pb-3">
                        <a href="clinic_settings.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" 
                           class="btn btn-outline-secondary rounded-circle">
                            <i class="fas fa-cogs"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
