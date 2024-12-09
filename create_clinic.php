<?php
session_start();
require_once 'database.php'; // Include the database connection

// Create a new Database object
$db = new Database();

// Function to generate a unique clinic code
function generateClinicCode() {
    $randomCode = strtoupper(bin2hex(random_bytes(3)));

    // Ensure the code is unique
    while (empty($randomCode) || checkIfCodeExists($randomCode)) {
        $randomCode = strtoupper(bin2hex(random_bytes(3)));
    }

    return $randomCode;
}

// Function to check if the code already exists in the database
function checkIfCodeExists($code) {
    global $db;
    $sql = "SELECT COUNT(*) FROM clinics WHERE clinic_code = :clinic_code";
    $stmt = $db->query($sql, ['clinic_code' => $code]);
    return $stmt->fetchColumn() > 0;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clinic_name = trim($_POST['clinic_name']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $specialization = trim($_POST['specialization']);
    $user_id = $_SESSION['user_id'];

    // Validate inputs
    if (empty($clinic_name) || empty($description) || empty($address) || empty($specialization)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: create_clinic.php");
        exit();
    }

    // Handle file uploads
    $profile_photo = null;
    $cover_photo = null;

    if (isset($_FILES['clinic_profile_photo']) && $_FILES['clinic_profile_photo']['error'] == 0) {
        $profile_photo = 'uploads/' . basename($_FILES['clinic_profile_photo']['name']);
        move_uploaded_file($_FILES['clinic_profile_photo']['tmp_name'], $profile_photo);
    }

    if (isset($_FILES['clinic_cover_photo']) && $_FILES['clinic_cover_photo']['error'] == 0) {
        $cover_photo = 'uploads/' . basename($_FILES['clinic_cover_photo']['name']);
        move_uploaded_file($_FILES['clinic_cover_photo']['tmp_name'], $cover_photo);
    }

    // Generate a unique clinic code
    $clinic_code = generateClinicCode();

    try {
        // Insert into clinics table
        $sql = "INSERT INTO clinics (user_id, clinic_name, description, address, specialization, clinic_code, clinic_profile_photo, clinic_cover_photo, created_at) 
                VALUES (:user_id, :clinic_name, :description, :address, :specialization, :clinic_code, :clinic_profile_photo, :clinic_cover_photo, NOW())";
        $params = [
            ':user_id' => $user_id,
            ':clinic_name' => $clinic_name,
            ':description' => $description,
            ':address' => $address,
            ':specialization' => $specialization,
            ':clinic_code' => $clinic_code,
            ':clinic_profile_photo' => $profile_photo,
            ':clinic_cover_photo' => $cover_photo
        ];
        $clinic_id = $db->insert($sql, $params);

        // Insert default settings
        $settings_sql = "INSERT INTO clinic_settings (clinic_id, allow_online_consultation, monday_open, tuesday_open, 
                         wednesday_open, thursday_open, friday_open, saturday_open, sunday_open, open_time, close_time, created_at) 
                         VALUES (:clinic_id, 0, 0, 0, 0, 0, 0, 0, 0, '09:00:00', '18:00:00', NOW())";
        $db->insert($settings_sql, [':clinic_id' => $clinic_id]);

        // Insert admin as a clinic member
        $member_sql = "INSERT INTO clinic_members (clinic_id, user_id, role, status, created_at) 
                       VALUES (:clinic_id, :user_id, 'admin', 'approved', NOW())";
        $db->insert($member_sql, [
            ':clinic_id' => $clinic_id,
            ':user_id' => $user_id
        ]);

        $_SESSION['success'] = "Clinic created successfully! Configure its settings now.";
        header("Location: clinic_settings.php?clinic_id=$clinic_id");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error creating clinic: " . $e->getMessage();
        header("Location: create_clinic.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Clinic</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Create Clinic</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="create_clinic.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="clinic_name" class="form-label">Clinic Name</label>
                        <input type="text" class="form-control" id="clinic_name" name="clinic_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" class="form-control" id="specialization" name="specialization" required>
                    </div>
                    <div class="mb-3">
                        <label for="clinic_profile_photo" class="form-label">Profile Photo</label>
                        <input type="file" class="form-control" id="clinic_profile_photo" name="clinic_profile_photo">
                    </div>
                    <div class="mb-3">
                        <label for="clinic_cover_photo" class="form-label">Cover Photo</label>
                        <input type="file" class="form-control" id="clinic_cover_photo" name="clinic_cover_photo">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Clinic</button>
                    </div>
                </form>
                <p class="text-center mt-3"><a href="clinics.php">Back to Clinics</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
