<?php
session_start();
$reg = $_SESSION['username'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "example";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$fromd = $_POST["fromd"];
$tod = $_POST["tod"];
$days = $_POST["days"];
$des=$_POST["dest"];
$reason = $_POST["reason"];

// Check if the values of fromd and tod already exist in the database
$sql = "SELECT * FROM outpass WHERE reg='$reg' AND fromd='$fromd' AND tod='$tod'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "You have already requested for outpass so please wait!!";
} else {
    // Insert data into database
    $sql = "INSERT INTO outpass (reg,fromd,tod,days,dest,reason) VALUES ('$reg','$fromd', '$tod','$days','$des','$reason')";

    if ($conn->query($sql) === TRUE) {
        echo "successfully recorded";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
echo"<br>";
echo "<a href='show.html'>back</a>";
$conn->close();

?>
