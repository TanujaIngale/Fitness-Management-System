<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Modify if needed
$password = ""; // Modify if needed
$dbname = "gym"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to count morning batch members
$sql = "SELECT COUNT(*) as total FROM members WHERE select_batch = 'mrg'";
$result = $conn->query($sql);

// Fetch and return count
$row = $result->fetch_assoc();
echo $row['total'];

// Close connection
$conn->close();
?>
