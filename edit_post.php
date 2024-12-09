<?php
session_start();
require_once 'database.php';

$db = new Database();
$post_id = $_GET['post_id'];

// Fetch the post
$sql = "SELECT * FROM clinic_posts WHERE post_id = :post_id";
$post = $db->query($sql, ['post_id' => $post_id])->fetch(PDO::FETCH_ASSOC);

// Ensure the user owns the post
if ($_SESSION['user_id'] != $post['user_id']) {
    die("Unauthorized access");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = trim($_POST['content']);
    $sql_update = "UPDATE clinic_posts SET content = :content WHERE post_id = :post_id";
    $db->update($sql_update, ['content' => $content, 'post_id' => $post_id]);
    header("Location: clinic_details.php?clinic_id=" . $post['clinic_id']);
    exit();
}
?>

<form action="" method="POST">
    <textarea name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>
    <button type="submit">Update</button>
</form>
