<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $batch = $_POST['select_batch'];
    $membership_plan = $_POST['membership_plan'];
    $payment_method = $_POST['payment_method'];
    $payment_amount = $_POST['payment_amount'];

    $sql = "UPDATE members SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone', dob='$dob', select_batch='$batch', membership_plan='$membership_plan', payment_method='$payment_method', payment_amount='$payment_amount' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();
?>
