<?php
require_once 'database.php'; // Include the database connection

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Create a new Database object
$db = new Database();

// Check if the user is subscribed
$sql = "SELECT subscribed FROM users WHERE user_id = :user_id";
$user = $db->query($sql, ['user_id' => $user_id])->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['subscribed'] == 0) {
    // Redirect to subscription page if not subscribed
    header('Location: subscription.php');
    exit();
}

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clinic_name = trim($_POST['clinic_name']);
    $specialization = trim($_POST['specialization']);
    $description = trim($_POST['description']);
    $address = trim($_POST['address']);
    $clinic_code = generateClinicCode();
    $cover_photo = ''; // Placeholder for cover photo path

    // Validate required fields
    if ($clinic_name && $specialization && $description && $address) {
        // Handle file upload
        if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            $file_name = time() . '_' . basename($_FILES['cover_photo']['name']);
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['cover_photo']['tmp_name'], $target_file)) {
                $cover_photo = $target_file;
            }
        }

        // Insert clinic details into the database
            $sql = "INSERT INTO clinics (clinic_code, user_id, clinic_name, specialization, description, address, clinic_cover_photo)
            VALUES (:clinic_code, :user_id, :clinic_name, :specialization, :description, :address, :clinic_cover_photo)";
            $params = [
            'clinic_code' => $clinic_code,
            'user_id' => $user_id,
            'clinic_name' => $clinic_name,
            'specialization' => $specialization,
            'description' => $description,
            'address' => $address,
            'clinic_cover_photo' => $cover_photo
            ];

            // Use the insert() method to execute the query and get the last inserted clinic_id
            $clinic_id = $db->insert($sql, $params);

            if ($clinic_id) {
            // Insert admin as a clinic member
            $member_sql = "INSERT INTO clinic_members (clinic_id, user_id, role, status, created_at) 
                    VALUES (:clinic_id, :user_id, 'admin', 'approved', NOW())";
            $db->insert($member_sql, [
            'clinic_id' => $clinic_id,
            'user_id' => $user_id
            ]);

            $_SESSION['success'] = 'Clinic created successfully!';
            header('Location: index_user.php?page=clinics');
            exit();
            } else {
            $_SESSION['error'] = 'Failed to create the clinic. Please try again.';
            }
        }
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
<div class="container mt-5">
    <h2 class="text-center mb-4">Create Clinic</h2>

    <!-- Display session messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Create Clinic Form -->
    <form action="create_clinic.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="clinic_name" class="form-label">Clinic Name</label>
            <input type="text" class="form-control" id="clinic_name" name="clinic_name" required>
        </div>
        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input type="text" class="form-control" id="specialization" name="specialization" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="cover_photo" class="form-label">Cover Photo</label>
            <input type="file" class="form-control" id="cover_photo" name="cover_photo" accept="image/*">
            <div id="preview_container" class="mt-3 border rounded" style="width: 100%; height: 300px; background-size: cover; background-repeat: no-repeat; background-position: center; display: none; cursor: grab;"></div>
        </div>
        <button type="submit" class="btn btn-primary">Create Clinic</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const coverPhotoInput = document.getElementById("cover_photo");
    const previewContainer = document.getElementById("preview_container");

    let isDragging = false;
    let startX, startY;
    let bgPosX = 50; // Center position
    let bgPosY = 50;

    coverPhotoInput.addEventListener("change", function () {
        const file = coverPhotoInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.style.backgroundImage = `url('${e.target.result}')`;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = "none";
        }
    });

    previewContainer.addEventListener("mousedown", function (e) {
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
        previewContainer.style.cursor = "grabbing";
    });

    document.addEventListener("mousemove", function (e) {
        if (isDragging) {
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            // Adjust background position based on drag distance
            bgPosX += dx / previewContainer.offsetWidth * 100;
            bgPosY += dy / previewContainer.offsetHeight * 100;

            previewContainer.style.backgroundPosition = `${bgPosX}% ${bgPosY}%`;

            // Update start position for next drag calculation
            startX = e.clientX;
            startY = e.clientY;
        }
    });

    document.addEventListener("mouseup", function () {
        if (isDragging) {
            isDragging = false;
            previewContainer.style.cursor = "grab";
        }
    });
});
</script>


</body>
</html>