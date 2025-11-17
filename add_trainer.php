<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$name = $_POST['name'];
$phone = $_POST['phone'];

// Image upload handling
$target_dir = "uploads/"; // Ensure 'uploads/' exists in your project root
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$image_name = basename($_FILES["image"]["name"]);
$target_file = $target_dir . time() . "_" . $image_name; // Prevent duplicate names
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

// Store relative path (not C:\wamp64\...)
$sql = "INSERT INTO trainers (name, image_url, phone) VALUES ('$name', '$target_file', '$phone')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}

$conn->close();
?>
