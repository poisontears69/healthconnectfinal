<?php
require_once 'database.php';
$db = new Database();

// Fetch all clinics (for initial load)
$sql_clinics = "SELECT * FROM clinics ORDER BY created_at DESC";
$clinics = $db->query($sql_clinics);

// Check if query execution was successful and data was retrieved
if ($clinics !== false && $clinics->rowCount() > 0) {
    $clinics = $clinics->fetchAll(PDO::FETCH_ASSOC);
} else {
    $clinics = [];  // Ensure $clinics is always an array, even if no data is found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="index_patient.css">
</head>
<body>
    <nav>
    <?php include 'navbar_patient.php'; ?>
    </nav>
    
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Find the Right Clinic for You</h1>
            <p class="lead">Search by location or specialization to connect with the best clinics in your area.</p>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="searchQuery" class="form-control" placeholder="Search clinics by name, location, or specialization" />
            </div>
        </div>
        <div class="container">
            <h2 class="text-center mb-4">Available Clinics</h2>
            <div class="row g-4" id="clinicResults">
                <!-- Clinics will be dynamically loaded here -->
                <?php if (!empty($clinics)): ?>
                    <?php foreach ($clinics as $clinic): ?>
                        <div class="col-md-4 clinic-card">
                            <div class="card">
                                <!-- Cover Photo with fallback to default if not available -->
                                <img src="<?php echo htmlspecialchars($clinic['clinic_cover_photo'] ?: 'default-cover.jpg'); ?>" class="cover-photo" alt="Cover Photo">
                                
                                <!-- Profile Photo with fallback to default if not available -->
                                <img src="<?php echo htmlspecialchars($clinic['clinic_profile_photo'] ?: 'default-profile.jpg'); ?>" class="profile-photo" alt="Profile Photo">
                                
                                <div class="card-body clinic-card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($clinic['clinic_name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($clinic['description'], 0, 100)); ?>...</p>
                                    <a href="view_clinic.php?clinic_id=<?php echo $clinic['clinic_id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No clinics available at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Clinics Section -->
    <section class="py-5">
        
    </section>

    <script>
        // Function to fetch clinics based on search query
        $(document).ready(function () {
            function fetchClinics(query) {
                $.ajax({
                    url: 'search_clinics.php',
                    type: 'GET',
                    data: { query: query },
                    success: function (response) {
                        $('#clinicResults').html(response); // Update the clinic results section
                    }
                });
            }

            // Trigger search when the user types in the search bar
            $('#searchQuery').on('input', function () {
                var query = $(this).val();
                fetchClinics(query);  // Dynamically fetch clinics based on the query
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
