<?php
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "gym"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total inquiries count
$sql = "SELECT COUNT(*) AS total FROM contact_messages";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalInquiries = $row['total'];

echo $totalInquiries; // Output total inquiries count

$conn->close();
?>
