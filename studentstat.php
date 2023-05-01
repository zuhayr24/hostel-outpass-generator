
<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "example";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT Id,fromd,tod,days,status,response FROM outpass";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  echo "<table>";
  echo "<tr><th>ID</th><th>fromdate</th><th>todate</th><th>days</th><th>Status</th><th>Response</th></tr>";
  
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["Id"] . "</td>";
    echo "<td>" . $row["fromd"] . "</td>";
    echo "<td>" . $row["tod"] . "</td>";
    echo "<td>" . $row["days"] . "</td>";
    echo "<td>" . $row["status"] . "</td>";
    
    if ($row["status"] == "Pending") {
      echo "<td>wait for response</td>";
    } 
    else if ($row["status"] == "accept") {
      echo "<td>Accepted</td>";
    } 
    else {
      echo "<td>" . $row["response"] . "</td>";
    }
  
    echo "</tr>";
}

  echo "</table>";
} else {
  echo "No data found";
}
echo "<a href='show.html'>back</a>";

mysqli_close($conn);
?>

