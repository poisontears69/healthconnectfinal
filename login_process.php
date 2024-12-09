<?php

// Include the Composer autoload file
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Start the session
session_start();

// Assuming the user sends email and password via POST
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die("Email and password are required.");
}

// Database connection (from database.php)
require_once 'database.php';

try {
    // Query to fetch the user from the database by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, start the session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];

        // Redirect to the dashboard or home page
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid credentials
        die("Invalid email or password.");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
