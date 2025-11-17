<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = "localhost";
$dbUsername = "root";  
$dbPassword = "";      
$dbname = "gym";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count total signups
$sql = "SELECT COUNT(*) AS total FROM signup";
$result = $conn->query($sql);

// Check for errors in query execution
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Fetch result
$row = $result->fetch_assoc();
$totalSignups = $row['total'];

// Output the total signups count
echo $totalSignups; 

// Close the database connection
$conn->close();
?>
