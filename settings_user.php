<!-- settings_user.php -->
<div class="settings-container">
    <h2>Account Settings</h2>

    <!-- Change Password Form -->
    <div class="mb-4">
        <h4>Change Password</h4>
        <form action="settings_user.php" method="POST">
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="update_password" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>

<?php
// PHP code to handle profile photo and password update

// Include database connection
include('database.php');


// Handle Password Change
if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password from the database
    $user_id = 1; // Replace with the actual user ID from the session or database
    $query = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();

    // Check if the current password is correct
    if (password_verify($current_password, $db_password)) {
        if ($new_password == $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password in the database
            $query = "UPDATE users SET password = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $hashed_password, $user_id);
            if ($stmt->execute()) {
                echo "<p class='text-success'>Password updated successfully!</p>";
            } else {
                echo "<p class='text-danger'>Failed to update password.</p>";
            }
        } else {
            echo "<p class='text-danger'>New password and confirmation do not match.</p>";
        }
    } else {
        echo "<p class='text-danger'>Current password is incorrect.</p>";
    }
}
?>
