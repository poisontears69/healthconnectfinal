<?php
session_start();
require_once 'database.php';

$db = new Database();
$post_id = $_GET['post_id'];
$clinic_id = $_GET['clinic_id'];

$sql = "DELETE FROM clinic_posts WHERE post_id = :post_id AND user_id = :user_id";
$db->delete($sql, ['post_id' => $post_id, 'user_id' => $_SESSION['user_id']]);

header("Location: clinic_details.php?clinic_id=$clinic_id");
exit();
