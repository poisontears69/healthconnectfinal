<?php
session_start();
require_once 'database.php'; // Include the database connection

$db = new Database();

// Get form data
$clinic_id = $_POST['clinic_id'];
$allow_online_consultation = isset($_POST['allow_online_consultation']) ? 1 : 0;
$monday_open = isset($_POST['monday_open']) ? 1 : 0;
$tuesday_open = isset($_POST['tuesday_open']) ? 1 : 0;
$wednesday_open = isset($_POST['wednesday_open']) ? 1 : 0;
$thursday_open = isset($_POST['thursday_open']) ? 1 : 0;
$friday_open = isset($_POST['friday_open']) ? 1 : 0;
$saturday_open = isset($_POST['saturday_open']) ? 1 : 0;
$sunday_open = isset($_POST['sunday_open']) ? 1 : 0;
$open_time = $_POST['open_time'];
$close_time = $_POST['close_time'];

// Update the clinic settings
$sql = "UPDATE clinic_settings SET 
        allow_online_consultation = :allow_online_consultation, 
        monday_open = :monday_open, 
        tuesday_open = :tuesday_open, 
        wednesday_open = :wednesday_open, 
        thursday_open = :thursday_open, 
        friday_open = :friday_open, 
        saturday_open = :saturday_open, 
        sunday_open = :sunday_open, 
        open_time = :open_time, 
        close_time = :close_time 
        WHERE clinic_id = :clinic_id";

$params = [
    ':clinic_id' => $clinic_id,
    ':allow_online_consultation' => $allow_online_consultation,
    ':monday_open' => $monday_open,
    ':tuesday_open' => $tuesday_open,
    ':wednesday_open' => $wednesday_open,
    ':thursday_open' => $thursday_open,
    ':friday_open' => $friday_open,
    ':saturday_open' => $saturday_open,
    ':sunday_open' => $sunday_open,
    ':open_time' => $open_time,
    ':close_time' => $close_time
];

try {
    $db->update($sql, $params);
    $_SESSION['success'] = "Clinic settings updated successfully!";
    header("Location: index_user.php?page=clinics"); // Redirect to clinics.php after successful update
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Error updating clinic settings: " . $e->getMessage();
    header("Location: clinic_settings.php?clinic_id=" . $clinic_id); // Redirect back on error
    exit();
}
