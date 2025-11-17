<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$id = $_POST['id'];

// Fetch image path before deleting
$sql = "SELECT image_url FROM trainers WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$imagePath = $row['image_url'];

// Delete image from the server
if (file_exists($imagePath)) {
    unlink($imagePath);
}

// Delete trainer from database
$sql = "DELETE FROM trainers WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}

$conn->close();
?>
