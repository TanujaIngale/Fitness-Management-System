<?php
$host = "localhost"; 
$dbname = "gym"; 
$user = "root"; 
$pass = ""; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM payment");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $row['total'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
