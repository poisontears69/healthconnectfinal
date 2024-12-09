<?php
session_start();
require_once 'database.php'; // Database connection
$db = new Database();

$clinic_id = $_GET['clinic_id'] ?? null;

// Fetch clinic details
$sql_clinic = "SELECT * FROM clinics WHERE clinic_id = :clinic_id";
$clinic = $db->query($sql_clinic, ['clinic_id' => $clinic_id])->fetch(PDO::FETCH_ASSOC);

// Fetch clinic members (staff)
$sql_members = "SELECT u.user_id, u.first_name, u.last_name, u.email 
                FROM clinic_members cm
                JOIN users u ON cm.user_id = u.user_id
                WHERE cm.clinic_id = :clinic_id";
$members = $db->query($sql_members, ['clinic_id' => $clinic_id])->fetchAll(PDO::FETCH_ASSOC);

// Fetch patients
$sql_patients = "SELECT * FROM patients WHERE clinic_id = :clinic_id";
$patients = $db->query($sql_patients, ['clinic_id' => $clinic_id])->fetchAll(PDO::FETCH_ASSOC);

// Fetch posts
$sql_posts = "SELECT cp.*, u.first_name, u.last_name FROM clinic_posts cp
              JOIN users u ON cp.user_id = u.user_id
              WHERE cp.clinic_id = :clinic_id ORDER BY cp.created_at DESC";
$posts = $db->query($sql_posts, ['clinic_id' => $clinic_id])->fetchAll(PDO::FETCH_ASSOC);

// Fetch settings (just an example for demonstration)
$sql_settings = "SELECT * FROM clinic_settings WHERE clinic_id = :clinic_id";
$settings = $db->query($sql_settings, ['clinic_id' => $clinic_id])->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cover-photo {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <!-- Clinic Profile Section -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <img src="<?php echo htmlspecialchars($clinic['clinic_cover_photo'] ?? 'default-cover.jpg'); ?>" 
                         class="cover-photo" alt="Cover Photo">
                </div>
                <div class="card-body">
                <h3 class="mt-2"><?php echo htmlspecialchars($clinic['clinic_name']); ?></h3>
                    <p><?php echo htmlspecialchars($clinic['description']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Navigation -->
    <div class="row">
        <div class="col-md-3">
            <?php include 'dashboard_clinic.php'; ?>
        </div>

        <!-- Dashboard Content -->
        <div class="col-md-9">
            <!-- Manage Clinic Members -->
            <div class="collapse" id="members">
                <div class="card mb-4">
                    <div class="card-header">Clinic Members</div>
                    <div class="card-body">
                        <h5>Clinic Staff</h5>
                        <ul class="list-group">
                            <?php foreach ($members as $member): ?>
                                <li class="list-group-item">
                                    <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                                    <small class="text-muted"><?php echo htmlspecialchars($member['email']); ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add Member</button>
                    </div>
                </div>
            </div>

            <!-- Manage Appointments -->
            <div class="collapse" id="appointments">
                <div class="card mb-4">
                    <div class="card-header">Manage Appointments</div>
                    <div class="card-body">
                        <a href="book_appointment.php?clinic_id=<?php echo $clinic_id; ?>" class="btn btn-primary">Book New Appointment</a>
                        <h5 class="mt-3">Upcoming Appointments</h5>
                        <ul class="list-group">
                            <!-- Add appointment listings here -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Manage Patients -->
            <div class="collapse" id="patients">
                <div class="card mb-4">
                    <div class="card-header">Manage Patients</div>
                    <div class="card-body">
                        <h5>Patient List</h5>
                        <ul class="list-group">
                            <?php foreach ($patients as $patient): ?>
                                <li class="list-group-item">
                                    <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                                    <small class="text-muted"><?php echo htmlspecialchars($patient['email']); ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Post News -->
            <div class="collapse" id="posts">
                <div class="card mb-4">
                    <div class="card-header">Post News</div>
                    <div class="card-body">
                        <form action="upload_post.php" method="POST">
                            <input type="hidden" name="clinic_id" value="<?php echo $clinic_id; ?>">
                            <div class="mb-3">
                                <textarea class="form-control" name="content" rows="3" placeholder="Write news here..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post News</button>
                        </form>
                        <h5 class="mt-3">Recent Posts</h5>
                        <ul class="list-group">
                            <?php foreach ($posts as $post): ?>
                                <li class="list-group-item">
                                    <strong><?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?>:</strong>
                                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                                    <small class="text-muted"><?php echo $post['created_at']; ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="collapse" id="settings">
                <div class="card mb-4">
                    <div class="card-header">Clinic Settings</div>
                    <div class="card-body">
                        <h5>General Settings</h5>
                        <form action="update_settings.php" method="POST">
                            <input type="hidden" name="clinic_id" value="<?php echo $clinic_id; ?>">
                            <!-- Add more settings here -->
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Add Member -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_member.php" method="POST">
                    <input type="hidden" name="clinic_id" value="<?php echo $clinic_id; ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Member</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
