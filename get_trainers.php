<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT * FROM trainers";
$result = $conn->query($sql);

$trainers = [];
while ($row = $result->fetch_assoc()) {
    // Append full path for frontend image display
    $row['image_url'] = "http://localhost/universal/" . $row['image_url'];
    $trainers[] = $row;
}

echo json_encode($trainers);
$conn->close();
?>
