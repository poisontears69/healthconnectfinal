<?php
session_start(); // Start the session

// Include database connection file
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));
    $roleType = htmlspecialchars(trim($_POST['roleType'])); // 1 for Doctor, 0 for Staff
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($first_name)) {
        $_SESSION['error'] = 'First Name is required.';
        header('Location: register.php');
        exit();
    }
    if (empty($last_name)) {
        $_SESSION['error'] = 'Last Name is required.';
        header('Location: register.php');
        exit();
    }
    if (empty($email)) {
        $_SESSION['error'] = 'Email is required.';
        header('Location: register.php');
        exit();
    }
    if (empty($contact_number)) {
        $_SESSION['error'] = 'Contact Number is required.';
        header('Location: register.php');
        exit();
    }
    if (empty($roleType) || !in_array($roleType, ['0', '1'])) { // Check valid roleType values
        $_SESSION['error'] = 'Role Type is required.';
        header('Location: register.php');
        exit();
    }
    if (empty($password)) {
        $_SESSION['error'] = 'Password is required.';
        header('Location: register.php');
        exit();
    }
    if (empty($confirm_password)) {
        $_SESSION['error'] = 'Confirm Password is required.';
        header('Location: register.php');
        exit();
    }
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format.';
        header('Location: register.php');
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: register.php');
        exit();
    }

    try {
        // Instantiate the Database class
        $database = new Database();
        $db = $database->getConnection();

        // Check if the email already exists
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = 'Email is already registered.';
            header('Location: register.php');
            exit();
        }


        // Insert the user into the database with roleType and subscribed set to 0
        $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, contact_number, roleType, password, subscribed, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, 0, NOW())");
        $stmt->execute([$first_name, $last_name, $email, $contact_number, $roleType, $password]);

        $_SESSION['success'] = 'Registration successful! Please log in.';
        header('Location: login.php');
        exit();
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = 'An error occurred. Please try again later.';
        header('Location: register.php');
        exit();
    }
} else {
    // Redirect to the registration page if the request method is not POST
    header('Location: register.php');
    exit();
}
