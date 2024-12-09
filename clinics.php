<?php
session_start();
require_once 'database.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Clinics</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for the settings icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .clinic-card {
            position: relative;
        }
        .cover-photo {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .profile-photo {
            position: absolute;
            top: 100px;
            left: 20px;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
        }
        .settings-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            color: #007bff;
        }
        .clinic-card-body {
            padding-top: 140px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Your Clinics</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); // Clear the error message after displaying it ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); // Clear the success message after displaying it ?>
        <?php endif; ?>

        <div class="row justify-content-center">
            <?php if (!$clinic): ?>
                <!-- If the user has no clinics, show a clickable card to create a clinic -->
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">No Clinic Created</h5>
                            <p class="card-text">You have not created any clinics yet.</p>
                            <a href="create_clinic.php" class="btn btn-primary">Create a Clinic</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- If the user has a clinic, display it -->
                <div class="col-md-4">
                    <div class="card clinic-card">
                        <!-- Display the cover photo -->
                        <img src="<?php echo htmlspecialchars($clinic['clinic_cover_photo']); ?>" class="cover-photo" alt="Cover Photo">

                        <!-- Display the profile photo -->
                        <img src="<?php echo htmlspecialchars($clinic['clinic_profile_photo']); ?>" class="profile-photo" alt="Profile Photo">

                        <div class="card-body clinic-card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($clinic['clinic_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($clinic['description']); ?></p>
                            <a href="clinic_details.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" class="btn btn-info">View Clinic</a>
                        </div>
                        <a href="clinic_settings.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" class="settings-icon">
                            <i class="fas fa-cogs"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
