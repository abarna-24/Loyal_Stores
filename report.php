<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_loyal";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

<a href="list.php"><button style="border-radius:5px;margin-top:3pc;margin-left:60pc;padding:1pc;background-color:rgb(255, 136, 0);color:white;border:none;">Stocks Page</button></a>
   
<?php
// Fetch data from the "raw" table
$sql = "SELECT product_code, product_name, quantity, size, date, taken_by FROM raw_release";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create an array to store the data
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "No data found.";
}
?>

<h1 style="text-align:center; margin:25px;">Raw Material Report</h1>

<?php
// Display the HTML table
if (!empty($data)) {
    echo '<table class="styled-table">';
    echo '<thead><tr><th>Product Code</th><th>Product Name</th><th>Quantity</th><th>Size</th><th>Date</th><th>Taken By</th></tr></thead>';
    echo '<tbody>';

    foreach ($data as $row) {
        echo '<tr>';
        echo '<td>' . $row["product_code"] . '</td>';
        echo '<td>' . $row["product_name"] . '</td>';
        echo '<td>' . $row["quantity"] . '</td>';
        echo '<td>' . $row["size"] . '</td>';
        echo '<td>' . $row["date"] . '</td>';
        echo '<td>' . $row["taken_by"] . '</td>';
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
