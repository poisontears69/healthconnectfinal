<?php
session_start();
require_once 'database.php';

$db = new Database();
$clinic_id = $_POST['clinic_id'];
$user_id = $_SESSION['user_id'];
$content = trim($_POST['content']);

if ($content) {
    $sql = "INSERT INTO clinic_posts (clinic_id, user_id, content) VALUES (:clinic_id, :user_id, :content)";
    $db->insert($sql, ['clinic_id' => $clinic_id, 'user_id' => $user_id, 'content' => $content]);
}
header("Location: clinic_details.php?clinic_id=$clinic_id");
