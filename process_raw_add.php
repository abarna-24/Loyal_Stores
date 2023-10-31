<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_loyal";
// ...
// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_code = $_POST["product_code"];
    $product_name = $_POST["product_name"];
    $department = $_POST["department"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $size = $_POST["size"];
    $units = $_POST["units"];
    $quantity = $_POST["quantity"];
    $storeman = $_POST["storeman"];
    $remarks = $_POST["remarks"];
    $given_by = $_POST["given_by"];
    $sql = "INSERT INTO raw_add (product_code, product_name, date, time, size, department, quantity, units, storeman, remarks, given_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Check for a prepare error
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameters and execute
    $stmt->bind_param("ssssssissss", $product_code, $product_name, $date, $time, $size, $department, $quantity, $units, $storeman, $remarks, $given_by);
    
    if ($stmt->execute()) {
        $_SESSION['status'] = "Product Added Successfully!!!";
        header("Location: list.php");

    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
    
}

?>
