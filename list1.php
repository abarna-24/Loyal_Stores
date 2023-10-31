<?php
  // Start a PHP session to manage user sessions
  session_start();

  // Database details
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "db_loyal";

  // Create a database connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check the database connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve data from the HTML form
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
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background: url('https://images.wallpaperscraft.com/image/single/light_faded_background_85547_300x168.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            -ms-background-size: cover;
            font-family: 'Raleway', sans-serif;
        }

        .styled-table {
            width: 60%;
            border-collapse: collapse;
            margin: 5pc 20pc;
            font-size: 0.9em;
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            background-color: white;
        }

        .styled-table th {
            background-color: rgb(255, 136, 0);
            color: #ffffff;
            text-align: center;
        }

        .styled-table th,
        .styled-table td {
            padding: 15px 15px;
        }

        .alert {
            text-align: center;
            background-color: green;
            padding: 5px;
        }

        .nav-button {
            border-radius: 5px;
            margin-top: 3pc;
            padding: 1pc;
            background-color: rgb(255, 136, 0);
            color: white;
            border: none;
        }
    </style>
</head>
<body>
<?php
if (isset($_SESSION['status'])) {
    echo '<h2 class="alert">' . $_SESSION['status'] . '</h2>';
    unset($_SESSION['status']);
}
?>
    <a href="addstock.html"><button style="border-radius:5px;margin-top:3pc;margin-left:60pc;padding:1pc;background-color:rgb(255, 136, 0);color:white;border:none;">Add Goods</button></a>
    <a href="releasestock.html"><button style="border-radius:5px;margin-top:3pc;margin-left:2pc;padding:1pc;background-color:rgb(255, 136, 0);color:white;border:none;">Release Goods</button></a>
    <a href="finished_report.php"><button style="border-radius:5px;margin-top:3pc;margin-left:2pc;padding:1pc;background-color:rgb(255, 136, 0);color:white;border:none;margin-right:50px;">Report</button></a>
<?php

// Fetch data from the "finish_add" table
$sql = "SELECT product_code, product_name, total FROM finish_add ORDER BY date ASC";
$result = $conn->query($sql);

if ($result->num_rows) {
    // Create an array to store the data
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "No data found.";
}
?>
<!-- Display the HTML table for finished goods -->
<h1 style="text-align:center; margin:25px;">Finished Goods Table</h1>

<?php

if (!empty($data)) {
    echo '<table class="styled-table">';
    echo '<thead><tr><th>Product Code</th><th>Product Name</th><th>Total</th></tr></thead>';
    echo '<tbody>';

    foreach ($data as $row) {
        echo '<tr>';
        echo '<td>' . $row["product_code"] . '</td>';
        echo '<td>' . $row["product_name"] . '</td>';
        echo '<td>' . $row["total"] . '</td>';
        
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table><br>';
} else {
    echo 'No items available!!!';
}
?>
</body>
</html>