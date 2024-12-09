<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['clinic_id'])) {
    $clinic_id = $_GET['clinic_id'];
    $db = new Database();
    try {
        $db->query("DELETE FROM clinics WHERE clinic_id = :clinic_id", ['clinic_id' => $clinic_id]);
        $_SESSION['success'] = "Clinic deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting clinic: " . $e->getMessage();
    }
}

header("Location: admin_dashboard.php");
exit();
