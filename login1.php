<?php
// Define your correct username and password
$correctUsername = "user";
$correctPassword = "12345";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];
    header("Location: list1.php");
    // Check if the entered username and password are correct
    if ($enteredUsername === $correctUsername && $enteredPassword === $correctPassword) {
        // Authentication successful, redirect to the next page
        header("Location: list.php");
        exit();
    } else {
        // Authentication failed, display an error message
        echo "Invalid username or password. Please try again.";
    }
}
?>