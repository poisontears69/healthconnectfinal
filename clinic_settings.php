<?php
session_start();
require_once 'database.php'; // Include the database connection

$db = new Database();

// Get clinic settings from database
$clinic_id = $_GET['clinic_id']; // Assuming you have the clinic_id to fetch settings

// Query the clinic settings from the database
$sql = "SELECT * FROM clinic_settings WHERE clinic_id = :clinic_id LIMIT 1";
$stmt = $db->query($sql, ['clinic_id' => $clinic_id]);

if ($stmt->rowCount() > 0) {
    $clinic_settings = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Handle case where clinic settings are not found (maybe create default settings)
    $clinic_settings = [
        'allow_online_consultation' => 0,
        'monday_open' => 0,
        'tuesday_open' => 0,
        'wednesday_open' => 0,
        'thursday_open' => 0,
        'friday_open' => 0,
        'saturday_open' => 0,
        'sunday_open' => 0,
        'open_time' => '09:00:00',
        'close_time' => '18:00:00'
    ];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Settings</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Clinic Settings</h2>

        <form action="save_clinic_settings.php" method="POST">
            <input type="hidden" name="clinic_id" value="<?php echo $clinic_id; ?>">

            <div class="mb-3">
                <label for="allow_online_consultation" class="form-label">Allow Online Consultation</label>
                <input type="checkbox" class="form-check-input" id="allow_online_consultation" name="allow_online_consultation" 
                    <?php echo $clinic_settings['allow_online_consultation'] == 1 ? 'checked' : ''; ?>>
            </div>

            <div class="mb-3">
                <label for="open_days" class="form-label">Select Open Days</label><br>
                <label><input type="checkbox" name="monday_open" value="1" <?php echo $clinic_settings['monday_open'] == 1 ? 'checked' : ''; ?>> Monday</label><br>
                <label><input type="checkbox" name="tuesday_open" value="1" <?php echo $clinic_settings['tuesday_open'] == 1 ? 'checked' : ''; ?>> Tuesday</label><br>
                <label><input type="checkbox" name="wednesday_open" value="1" <?php echo $clinic_settings['wednesday_open'] == 1 ? 'checked' : ''; ?>> Wednesday</label><br>
                <label><input type="checkbox" name="thursday_open" value="1" <?php echo $clinic_settings['thursday_open'] == 1 ? 'checked' : ''; ?>> Thursday</label><br>
                <label><input type="checkbox" name="friday_open" value="1" <?php echo $clinic_settings['friday_open'] == 1 ? 'checked' : ''; ?>> Friday</label><br>
                <label><input type="checkbox" name="saturday_open" value="1" <?php echo $clinic_settings['saturday_open'] == 1 ? 'checked' : ''; ?>> Saturday</label><br>
                <label><input type="checkbox" name="sunday_open" value="1" <?php echo $clinic_settings['sunday_open'] == 1 ? 'checked' : ''; ?>> Sunday</label>
            </div>

            <div class="mb-3">
                <label for="open_time" class="form-label">Open Time</label>
                <input type="time" class="form-control" id="open_time" name="open_time" value="<?php echo $clinic_settings['open_time']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="close_time" class="form-label">Close Time</label>
                <input type="time" class="form-control" id="close_time" name="close_time" value="<?php echo $clinic_settings['close_time']; ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
