<?php
// register_process.php

// Include database connection file
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($first_name) || empty($last_name) || empty($email) || empty($contact_number) || empty($password) || empty($confirm_password)) {
        die("<script>alert('All fields are required.'); window.history.back();</script>");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<script>alert('Invalid email format.'); window.history.back();</script>");
    }

    if ($password !== $confirm_password) {
        die("<script>alert('Passwords do not match.'); window.history.back();</script>");
    }


    try {
        // Instantiate the Database class
        $database = new Database();
        $db = $database->getConnection();

        // Check if the email already exists
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            die("<script>alert('Email is already registered.'); window.history.back();</script>");
        }

        // Insert the user into the database
        $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, contact_number, password, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$first_name, $last_name, $email, $contact_number, $password]);

        echo "<script>alert('Registration successful! Please log in.'); window.location.href='login.php';</script>";
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        die("<script>alert('An error occurred. Please try again later.'); window.history.back();</script>");
    }
} else {
    // Redirect to the registration page if the request method is not POST
    header('Location: register.php');
    exit();
}
