<?php
require_once 'database.php';
$db = new Database();

// Get the search query from GET request
$query = isset($_GET['query']) ? $_GET['query'] : '';

// If no search query, display all clinics
if (empty($query)) {
    $sql_clinics = "SELECT * FROM clinics ORDER BY created_at DESC";
    $clinics = $db->query($sql_clinics)->fetchAll(PDO::FETCH_ASSOC);
} else {
    // SQL query to fetch clinics based on search query
    $sql_clinics = "SELECT * FROM clinics WHERE clinic_name LIKE :query ORDER BY created_at DESC";
    
    // Prepare and execute query with parameters
    $stmt = $db->getConnection()->prepare($sql_clinics);  // Correcting this to use the database connection
    $stmt->execute(['query' => '%' . $query . '%']);
    $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if clinics are found
if ($clinics && count($clinics) > 0) {
    foreach ($clinics as $clinic) {
        echo '<div class="col-md-4 clinic-card">
                <div class="card">
                    <!-- Cover Photo with fallback to default if not available -->
                    <img src="' . htmlspecialchars($clinic['clinic_cover_photo'] ?? 'default-cover.jpg') . '" class="cover-photo card-img-top" alt="Clinic Cover Photo">
                    
                    <!-- Profile Photo with fallback to default if not available -->
                    <img src="' . htmlspecialchars($clinic['clinic_profile_photo'] ?? 'default-profile.jpg') . '" class="profile-photo" alt="Clinic Profile Photo">
                    
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($clinic['clinic_name']) . '</h5>
                        <p class="card-text">' . htmlspecialchars(substr($clinic['description'], 0, 100)) . '...</p>
                        <a href="view_clinic.php?clinic_id=' . $clinic['clinic_id'] . '" class="btn btn-primary">View Details</a>
                    </div>
                </div>
              </div>';
    }
} else {
    echo '<p>No clinics found matching your search criteria.</p>';
}
?>
