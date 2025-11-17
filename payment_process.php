<?php
session_start();

// Database connection (directly in this file)
$host = 'localhost';
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "gym"; // Replace with your database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = trim($_POST['customerName']);
    $customer_email = trim($_POST['customerEmail']);
    $customer_address = trim($_POST['customerAddress']);
    $payment_method = trim($_POST['paymentMethod']);
    $total_amount = trim($_POST['totalAmount']);

    // Validate required fields
    if (empty($customer_name) || empty($customer_email) || empty($customer_address) || empty($payment_method) || empty($total_amount)) {
        die("Error: All fields are required!");
    }

    // Insert payment details into the database
    try {
        $sql = "INSERT INTO payment (customer_name, customer_email, customer_address, payment_method, total_amount) 
                VALUES (:customer_name, :customer_email, :customer_address, :payment_method, :total_amount)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':customer_name' => $customer_name,
            ':customer_email' => $customer_email,
            ':customer_address' => $customer_address,
            ':payment_method' => $payment_method,
            ':total_amount' => $total_amount
        ]);

        // Clear the cart from localStorage using JavaScript after successful order
        echo "<script>
                localStorage.removeItem('cart');
                localStorage.removeItem('totalAmount');
                alert('Payment successful! Order placed.');
                window.location.href = 'customer.html';
              </script>";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
