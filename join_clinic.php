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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clinic_code = trim($_POST['clinic_code']);

    if ($clinic_code) {
        // Check if the clinic exists
        $sql = "SELECT clinic_id FROM clinics WHERE clinic_code = :clinic_code";
        $clinic = $db->query($sql, ['clinic_code' => $clinic_code])->fetch(PDO::FETCH_ASSOC);

        if ($clinic) {
            $clinic_id = $clinic['clinic_id'];

            // Check if the user is already a member of this clinic
            $sql = "SELECT COUNT(*) FROM clinic_members WHERE clinic_id = :clinic_id AND user_id = :user_id";
            $is_member = $db->query($sql, ['clinic_id' => $clinic_id, 'user_id' => $user_id])->fetchColumn();

            if ($is_member > 0) {
                $_SESSION['error'] = 'You are already a member of this clinic.';
            } else {
                // Add the user as a pending member
                $sql = "INSERT INTO clinic_members (clinic_id, user_id, role, status, created_at) 
                        VALUES (:clinic_id, :user_id, 'member', 'pending', NOW())";
                $db->insert($sql, [
                    'clinic_id' => $clinic_id,
                    'user_id' => $user_id
                ]);

                $_SESSION['success'] = 'Your request to join the clinic has been sent successfully.';
                header('Location: index_user.php?page=clinics');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Clinic not found. Please check the code and try again.';
        }
    } else {
        $_SESSION['error'] = 'Please enter a clinic code.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Join Clinic</title>
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
    <h2 class="text-center mb-4">Join Clinic</h2>

    <!-- Display session messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <!-- Join Clinic Form -->
    <form action="join_clinic.php" method="POST">
        <div class="mb-3">
            <label for="clinic_code" class="form-label">Clinic Code</label>
            <input type="text" class="form-control" id="clinic_code" name="clinic_code" placeholder="Enter clinic code" required>
        </div>
        <button type="submit" class="btn btn-primary">Join Clinic</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

