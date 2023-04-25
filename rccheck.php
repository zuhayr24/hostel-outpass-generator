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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Loop through each row and update the status and response if an action was selected
  foreach ($_POST["action"] as $id => $status) {
    $sql = "UPDATE outpass SET status='$status'";
    $sql .= ($status == "reject" && isset($_POST["response"][$id])) ? ", response='" . mysqli_real_escape_string($conn, $_POST["response"][$id]) . "'" : "";
    $sql .= " WHERE Id='$id'";
    mysqli_query($conn, $sql);
  }
}




// Query the database to get the data you want to display
$sql = "SELECT * FROM outpass ORDER BY fromd ASC";
$result = mysqli_query($conn, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
  // Create a table to display the data
  echo "<form method='POST'>";
  echo "<table>";
  echo "<tr><th>ID</th><th>From Date</th><th>To Date</th><th>Number of Days</th><th>Destination</th><th>Reason</th><th>Status</th><th>Action</th></tr>";
  
  // Loop through each row and display the data
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["Id"] . "</td>";
    echo "<td>" . $row["reg"] . "</td>";
    echo "<td>" . $row["fromd"] . "</td>";
    echo "<td>" . $row["tod"] . "</td>";
    echo "<td>" . $row["days"] . "</td>";
    echo "<td>" . $row["dest"] . "</td>";
    echo "<td>" . $row["reason"] . "</td>";
    echo "<td>" . $row["status"] . "</td>";
    echo "<td>";
    if ($row["status"] != "accept" && $row["status"] != "reject") {
      echo "<input type='radio' name='action[" . $row["Id"] . "]' value='accept'>Accept";
      echo "<input type='radio' name='action[" . $row["Id"] . "]' value='reject' onclick='createResponseTextBox(this)'>Reject";
    }
    echo "</td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "<input type='submit' value='Submit'>";
  


  echo "</form>";
} else {
  echo "No data found";
}

// Close the database connection
mysqli_close($conn);
?>

<script>
function createResponseTextBox(button) {
  if (button.checked && button.value === 'reject') {
    const textBox = document.createElement('input');
    textBox.type = 'text';
    textBox.name = 'response';
    textBox.placeholder = 'Enter rejection reason';
    textBox.required = true;
    document.getElementById('response-container').appendChild(textBox);
  }
}
</script>

<a href="rc.html">Back</a>

<div id="response-container"></div>
