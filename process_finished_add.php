<?php
  // Start a session for user data persistence
  session_start();
  // Database details
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "db_loyal";
  // Create a new MySQLi database connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check and handle database connection errors
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve data from the form using POST method
  $product_code = $_POST["product_code"];
  $product_name = $_POST["product_name"];
  $date = $_POST["date"];
  $time = $_POST["time"];
  $size6 = $_POST["size6"];
  $size7 = $_POST["size7"];
  $size8 = $_POST["size8"];
  $size9 = $_POST["size9"];
  $size10 = $_POST["size10"];
  $size11 = $_POST["size11"];
  $total = $_POST["total"];
  $storeman = $_POST["storeman"];
  $remarks = $_POST["remarks"];
  $given_by = $_POST["given_by"];

  // SQL query to insert data into the 'finish_add' table
  $sql = "INSERT INTO finish_add (product_code, product_name, date, time, size6, size7, size8, size9, size10, size11, total, storeman, remarks, given_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
    
  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  /// Bind the form data to the SQL statement
  $stmt->bind_param("ssssiiiiiissss", $product_code, $product_name, $date, $time, $size6, $size7, $size8, $size9, $size10, $size11, $total, $storeman, $remarks, $given_by);
   
  if ($stmt->execute()) {
      $_SESSION['status'] = "Product Added Successfully!!!";
      // Redirect to another page (list1.php in this case)
      header("Location: list1.php");

  } else {
      echo "Error: " . $stmt->error;
  }

  $stmt->close(); // Close the prepared statement
  $conn->close(); // Close the database connection

  }
?>