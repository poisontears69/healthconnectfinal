<?php
session_start();
require_once 'database.php';

$db = new Database();
$photo_id = $_GET['photo_id'];
$clinic_id = $_GET['clinic_id'];

// Fetch the photo path
$sql = "SELECT photo_path FROM clinic_photos WHERE photo_id = :photo_id AND user_id = :user_id";
$photo = $db->query($sql, ['photo_id' => $photo_id, 'user_id' => $_SESSION['user_id']])->fetch(PDO::FETCH_ASSOC);

if ($photo) {
    unlink($photo['photo_path']); // Delete the file
    $sql_delete = "DELETE FROM clinic_photos WHERE photo_id = :photo_id";
    $db->delete($sql_delete, ['photo_id' => $photo_id]);
}

header("Location: clinic_details.php?clinic_id=$clinic_id");
exit();
