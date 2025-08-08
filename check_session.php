<?php
session_start();

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Function to get current user ID
function get_user_id() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

// Function to get current user email
function get_user_email() {
    return isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
}

// Function to require login (redirect if not logged in)
function require_login() {
    if (!is_logged_in()) {
        header("Location: GWF  SIGNIN.html");
        exit();
    }
}
?> 