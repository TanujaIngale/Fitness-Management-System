<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "gym"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL statement
$sql = "SELECT * FROM signup WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found
    session_start();
    $_SESSION['email'] = $email;
    header("Location: admin.html"); // Redirect to a welcome page
} else {
    // User not found
    echo "Invalid email or password.";
}

$stmt->close();
$conn->close();
?>
