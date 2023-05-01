<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "example";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST["action"] as $id => $status) {
        $sql = "UPDATE outpass SET status='$status'";
        $sql .= ($status == "reject" && isset($_POST["response"][$id])) ? ", response='" . mysqli_real_escape_string($conn, $_POST["response"][$id]) . "'" : "";
        $sql .= " WHERE Id='$id'";
        mysqli_query($conn, $sql);
    }
}

$sql = "SELECT * FROM outpass ORDER BY fromd ASC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<form method='POST'>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Regn</th><th>From Date</th><th>To Date</th><th>Number of Days</th><th>Destination</th><th>Reason</th><th>Status</th><th>Action</th><th>Response</th></tr>";

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
      echo "<td>" .$row["response"] ."</td>";
      echo "<td>";
      if ($row["status"] != "accept" && $row["status"] != "reject") {
          echo "<input type='radio' name='action[" . $row["Id"] . "]' value='accept'>Accept";
          echo "<input type='radio' name='action[" . $row["Id"] . "]' value='reject' onclick='createResponseTextBox(this)'>Reject";
      } else if ($row["status"] == "reject" && !empty($row["response"])) {
          echo "<input type='hidden' name='response[" . $row["Id"] . "]' value='" . htmlspecialchars($row["response"]) . "'>";
      }
      echo "</td>";
      echo "</tr>";
  }
  
    echo "</table>";
    echo "<div id='response-container'></div>";
    echo "<input type='submit' value='Submit'>";
    echo "</form>";
} else {
    echo "No data found";
}

mysqli_close($conn);
?>

<script>
function createResponseTextBox(button) {
    if (button.checked && button.value === 'reject') {
        const rowId = button.parentNode.parentNode.childNodes[0].innerHTML;
        const existingResponse = document.querySelector(`input[name='response[${rowId}]']`);
        if (existingResponse) {
            existingResponse.type = 'text';
            existingResponse.required = true;
        } else {
            const textBox = document.createElement('input');
            textBox.type = 'text';
            textBox.name = `response[${rowId}]`;
            textBox.placeholder = 'Enter reason';
            textBox.required = true;
            const idLabel = document.createElement('label');
            idLabel.innerHTML = `ID ${rowId}`;
            document.getElementById('response-container').appendChild(idLabel);
            document.getElementById('response-container').appendChild(textBox);
        }
    } else {
        const rowId = button.parentNode.parentNode.childNodes[0].innerHTML;
        const existingResponse = document.querySelector(`input[name='response[${rowId}]']`);
        if (existingResponse) {
            existingResponse.type = 'hidden';
            existingResponse.required = false;
            const idLabel = document.querySelector(`label[for='response[${rowId}]']`);
            idLabel.parentNode.removeChild(idLabel);
        }
    }
}


</script>

<a href="rc.html">Back</a>
