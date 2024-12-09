<?php
session_start();
require_once 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Create a new Database object
$db = new Database();

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clinic_code = trim($_POST['clinic_code']);

    if (empty($clinic_code)) {
        $_SESSION['error'] = "Clinic code is required.";
        header("Location: join_clinic.php");
        exit();
    }

    try {
        // Check if the clinic exists
        $clinic_query = "SELECT * FROM clinics WHERE clinic_code = :clinic_code";
        $clinic_stmt = $db->query($clinic_query, ['clinic_code' => $clinic_code]);
        $clinic = $clinic_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$clinic) {
            $_SESSION['error'] = "Clinic not found. Please check the clinic code.";
            header("Location: join_clinic.php");
            exit();
        }

        $clinic_id = $clinic['clinic_id'];

        // Check if the user already has a membership request or is a member
        $membership_query = "SELECT * FROM clinic_members WHERE clinic_id = :clinic_id AND user_id = :user_id";
        $membership_stmt = $db->query($membership_query, ['clinic_id' => $clinic_id, 'user_id' => $user_id]);
        $membership = $membership_stmt->fetch(PDO::FETCH_ASSOC);

        if ($membership) {
            if ($membership['status'] === 'pending') {
                $_SESSION['error'] = "You have already requested to join this clinic. Please wait for approval.";
            } elseif ($membership['status'] === 'approved') {
                $_SESSION['error'] = "You are already a member of this clinic.";
            } elseif ($membership['status'] === 'denied') {
                $_SESSION['error'] = "Your request to join this clinic was denied.";
            }
            header("Location: join_clinic.php");
            exit();
        }

        // Insert a new membership request with 'pending' status
        $join_query = "INSERT INTO clinic_members (clinic_id, user_id, status, joined_at) 
                       VALUES (:clinic_id, :user_id, 'pending', NOW())";
        $db->query($join_query, ['clinic_id' => $clinic_id, 'user_id' => $user_id]);

        $_SESSION['success'] = "Request to join the clinic has been submitted. Please wait for approval.";
        header("Location: your_clinics.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: join_clinic.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Clinic</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar_clinic.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Join a Clinic</h2>

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

        <form method="POST" action="join_clinic.php">
            <div class="mb-3">
                <label for="clinic_code" class="form-label">Clinic Code</label>
                <input type="text" name="clinic_code" id="clinic_code" class="form-control" placeholder="Enter the clinic code" required>
            </div>
            <button type="submit" class="btn btn-primary">Join Clinic</button>
        </form>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
