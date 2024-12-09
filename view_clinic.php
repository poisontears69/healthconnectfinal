<?php
require_once 'database.php'; // Database connection
$db = new Database();

$clinic_id = $_GET['clinic_id'] ?? null;

// Fetch clinic details
$sql_clinic = "SELECT * FROM clinics WHERE clinic_id = :clinic_id";
$clinic = $db->query($sql_clinic, ['clinic_id' => $clinic_id])->fetch(PDO::FETCH_ASSOC);

// Fetch posts
$sql_posts = "SELECT cp.*, u.first_name, u.last_name FROM clinic_posts cp 
              JOIN users u ON cp.user_id = u.user_id
              WHERE cp.clinic_id = :clinic_id 
              ORDER BY cp.created_at DESC";
$posts = $db->query($sql_posts, ['clinic_id' => $clinic_id])->fetchAll(PDO::FETCH_ASSOC);

// Fetch photos
$sql_photos = "SELECT * FROM clinic_photos WHERE clinic_id = :clinic_id ORDER BY uploaded_at DESC";
$photos = $db->query($sql_photos, ['clinic_id' => $clinic_id])->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .photo-thumbnail {
            max-width: 150px; /* Limit the width */
            max-height: 150px; /* Limit the height */
            object-fit: cover; /* Maintain aspect ratio while cropping excess */
            border-radius: 5px; /* Add some rounding for a polished look */
            cursor: pointer; /* Indicate the image is clickable */
        }
        .modal-content {
            position: relative;
        }
        .book-appointment-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050; /* Ensure it stays above other content */
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <!-- Book Appointment Button -->
    <a href="book_appointment.php?clinic_id=<?php echo $clinic_id; ?>" class="btn btn-success book-appointment-btn">
        Book an Appointment
    </a>

    <div class="row">
        <!-- Sidebar for Photos -->
        <div class="col-md-4">
            <h4>Photos</h4>
            <!-- Display Photos -->
            <div class="row">
                <?php foreach ($photos as $index => $photo): ?>
                    <div class="col-6 mb-3">
                        <img src="<?php echo htmlspecialchars($photo['photo_path']); ?>" 
                             class="img-fluid photo-thumbnail" 
                             alt="Photo" 
                             data-bs-toggle="modal" 
                             data-bs-target="#photoModal<?php echo $index; ?>">
                    </div>

                    <!-- Modal for Full-Screen Photo -->
                    <div class="modal fade" id="photoModal<?php echo $index; ?>" tabindex="-1" aria-labelledby="photoModalLabel<?php echo $index; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <img src="<?php echo htmlspecialchars($photo['photo_path']); ?>" class="img-fluid" alt="Full-Screen Photo">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Main Content: Page Wall -->
        <div class="col-md-8">
            <h2><?php echo htmlspecialchars($clinic['clinic_name']); ?></h2>
            <p><?php echo htmlspecialchars($clinic['description']); ?></p>

            <!-- Timeline of Posts -->
            <h4>Posts</h4>
            <?php foreach ($posts as $post): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6><?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?></h6>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <small class="text-muted"><?php echo $post['created_at']; ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
