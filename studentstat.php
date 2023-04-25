<?php
// Database configuration
$host = "localhost"; // Replace with your host name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "example"; // Replace with your database name

// Create a connection to the database
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Query the database to get the data you want to display
$sql = "SELECT Id,fromd,tod,days,status,response FROM outpass";
$result = mysqli_query($conn, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
  // Create a table to display the data
  echo "<table>";
  echo "<tr><th>ID</th><th>fromdate</th><th>todate</th><th>days</th><th>Status</th><th>Response</th></tr>";
  
  // Loop through each row and display the data
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["Id"] . "</td>";
    echo "<td>" . $row["fromd"] . "</td>";
    echo "<td>" . $row["tod"] . "</td>";
    echo "<td>" . $row["days"] . "</td>";
    echo "<td>" . $row["status"] . "</td>";
    echo "<td>" . $row["response"]. "</td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "No data found";
}

// Close the database connection
mysqli_close($conn);
?>
