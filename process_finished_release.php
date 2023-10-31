<?php
  // Start a session for user data persistence
  session_start();
  //Database details
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
  $taken_by = $_POST["taken_by"];
  
    // Check if the product exists and has sufficient quantity
    $sql = "SELECT * FROM finish_add WHERE product_code = ? AND product_name = ?";
    $stmt = $conn->prepare($sql);

    // Check for a prepare error
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameters and execute
    $stmt->bind_param("ss", $product_code, $product_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $available_quantity = $row["total"];

        // Check if the available quantity is sufficient
           if ($available_quantity >= $total) {
            // Update the database to reduce the quantity
            $new_quantity = $available_quantity - $total;
            $update_sql = "UPDATE finish_add SET total = ? WHERE product_code = ? AND product_name = ?";
            $update_stmt = $conn->prepare($update_sql);

            // Check for a prepare error
            if (!$update_stmt) {    
                die("Prepare failed: " . $conn->error);
            }

            // Bind the parameters and execute the update
            $update_stmt->bind_param("iss", $new_quantity, $product_code, $product_name);

            if ($update_stmt->execute()) {
                $_SESSION['status'] = "Product Released Successfully!";
                
                $sql = "INSERT INTO finish_release (product_code, product_name, date, time, size6, size7, size8, size9, size10, size11, total, storeman, remarks, taken_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                  
            
                // Check for a prepare error
                if (!$stmt) {
                    die("Prepare failed: " . $conn->error);
                }
            
                $stmt->bind_param("ssssiiiiiissss", $product_code, $product_name, $date, $time, $size6, $size7, $size8, $size9, $size10, $size11, $total, $storeman, $remarks, $taken_by);
   
                if ($stmt->execute()) {
                    // Redirect after successful insertion
                    header("Location: list1.php");
                } else {
                    echo "Error inserting data into raw_release table: " . $stmt->error;
                }
            } else {
                echo "Error updating quantity: " . $update_stmt->error;
            }
            
            // Close the update statement
            $update_stmt->close();
        } else {
            $_SESSION['status'] = "Insufficient Quantity!";
            header("Location: list1.php"); // Redirect to an appropriate page
        }
    } else {
        $_SESSION['status'] = "Product Not Found!";
        header("Location: list1.php"); // Redirect to an appropriate page
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
