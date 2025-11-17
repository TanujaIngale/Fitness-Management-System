<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change this if required
$password = ""; // Change this if required
$dbname = "gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $select_batch = $_POST['select_batch'];
    $membership_plan = $_POST['membership_plan'];
    $payment_method = $_POST['payment_method'];
    $payment_amount = $_POST['payment_amount'];

    // Prepare SQL statement
    $sql = "INSERT INTO members (first_name, last_name, email, phone, dob,select_batch, membership_plan, payment_method, payment_amount) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$dob','$select_batch', '$membership_plan', '$payment_method', $payment_amount)";

    // Execute SQL query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "New membership record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Close the connection
    $conn->close();
}
?>
