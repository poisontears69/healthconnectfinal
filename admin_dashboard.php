<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$db = new Database();

// Fetch clinics and users
$clinics = $db->query("SELECT * FROM clinics")->fetchAll(PDO::FETCH_ASSOC);
$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Clinics Section -->
        <h2>Clinics</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clinics as $clinic): ?>
                    <tr>
                        <td><?php echo $clinic['clinic_id']; ?></td>
                        <td><?php echo htmlspecialchars($clinic['clinic_name']); ?></td>
                        <td><?php echo htmlspecialchars($clinic['description']); ?></td>
                        <td><?php echo $clinic['created_at']; ?></td>
                        <td>
                            <a href="edit_clinic.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_clinic.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this clinic?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_clinic.php" class="btn btn-primary">Add Clinic</a>

        <!-- Users Section -->
        <h2 class="mt-5">Users</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo $user['created_at']; ?></td>
                        <td>
                            <a href="edit_user.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_user.php?user_id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_user.php" class="btn btn-primary">Add User</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
