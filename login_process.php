<?php
session_start();
require_once 'database.php'; // Include the database connection

// Create a new Database object
$db = new Database();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email and password are not empty
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: login.php");
        exit();
    }

    // Query the database to find the user by email
    $sql = "SELECT user_id, password FROM users WHERE email = :email LIMIT 1";
    $stmt = $db->query($sql, ['email' => $email]);

    // Check if the email exists
    if ($stmt->rowCount() > 0) {
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($password == $user['password']) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $email;

            // Redirect to the dashboard or home page
            header("Location: clinics.php"); // Replace with your landing page
            exit();
        } else {
            // Password is incorrect
            $_SESSION['error'] = "Incorrect password.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Email does not exist
        $_SESSION['error'] = "No account found with that email address.";
        header("Location: login.php");
        exit();
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: login.php");
    exit();
}
?>
