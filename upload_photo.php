<?php
session_start();
require_once 'database.php';

$db = new Database();
$clinic_id = $_POST['clinic_id'];
$user_id = $_SESSION['user_id'];
$target_dir = "uploads/clinic_photos/";
$file_name = basename($_FILES['photo']['name']);
$target_file = $target_dir . uniqid() . "_" . $file_name;

if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
    $sql = "INSERT INTO clinic_photos (clinic_id, user_id, photo_path) VALUES (:clinic_id, :user_id, :photo_path)";
    $db->insert($sql, ['clinic_id' => $clinic_id, 'user_id' => $user_id, 'photo_path' => $target_file]);
}
header("Location: clinic_details.php?clinic_id=$clinic_id");
