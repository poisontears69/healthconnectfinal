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
    $clinics = $db->query($sql_clinics, ['query' => '%' . $query . '%'])->fetchAll(PDO::FETCH_ASSOC);
}

// Check if clinics are found
if ($clinics) {
    foreach ($clinics as $clinic) {
        echo '<div class="col-md-4 clinic-card">
                <div class="card">
                    <img src="' . htmlspecialchars($clinic['image'] ?? 'default-clinic.jpg') . '" class="card-img-top" alt="Clinic Image">
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
