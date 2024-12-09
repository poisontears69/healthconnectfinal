<?php
session_start();
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
        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1051; /* Ensure it stays above other content */
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar for Photos -->
        <div class="col-md-4">
            <h4>Photos</h4>
            <!-- Upload Photo -->
            <form action="upload_photo.php" method="POST" enctype="multipart/form-data" class="mb-4">
                <input type="hidden" name="clinic_id" value="<?php echo $clinic_id; ?>">
                <div class="mb-3">
                    <input type="file" class="form-control" name="photo" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

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
                                <!-- Delete Button -->
                                <a href="delete_photo.php?photo_id=<?php echo $photo['photo_id']; ?>&clinic_id=<?php echo $clinic_id; ?>" 
                                   class="btn btn-danger delete-button" 
                                   onclick="return confirm('Are you sure you want to delete this photo?');">
                                    Delete
                                </a>
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

            <!-- Upload Post -->
            <form action="upload_post.php" method="POST" class="mb-4">
                <input type="hidden" name="clinic_id" value="<?php echo $clinic_id; ?>">
                <div class="mb-3">
                    <textarea class="form-control" name="content" rows="3" placeholder="Write something..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>

            <!-- Timeline of Posts -->
            <h4>Posts</h4>
            <?php foreach ($posts as $post): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6><?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?></h6>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <small class="text-muted"><?php echo $post['created_at']; ?></small>

                        <!-- Edit and Delete Buttons -->
                        <?php if ($_SESSION['user_id'] == $post['user_id']): ?>
                            <div class="mt-2">
                                <a href="edit_post.php?post_id=<?php echo $post['post_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_post.php?post_id=<?php echo $post['post_id']; ?>&clinic_id=<?php echo $clinic_id; ?>" 
                                class="btn btn-sm btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this post?');">
                                    Delete
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>