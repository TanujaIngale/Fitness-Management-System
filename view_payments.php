<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all payments
$sql = "SELECT * FROM payment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal Gym - Completed Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/hero-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: black;
            text-align: center;
        }
        .container {
            padding: 20px;
            margin-top: 20px;
        }
        .table {
            background: white;
            color: black;
        }
    </style>
    <script>
        function printSelected() {
            let selectedRows = document.querySelectorAll('input[name="selectRow"]:checked');
            if (selectedRows.length === 0) {
                alert("Please select at least one record to print.");
                return;
            }

            let printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Print Payment Records</title></head><body>');
            printWindow.document.write('<h2 style="text-align: center;">Universal Gym - Selected Payment Records</h2>');
            printWindow.document.write('<table border="1" width="100%" style="border-collapse: collapse; text-align: center;">');
            printWindow.document.write('<tr><th>ID</th><th>Customer Name</th><th>Email</th><th>Address</th><th>Payment Method</th><th>Total Amount (₹)</th></tr>');

            selectedRows.forEach(row => {
                let tr = row.closest('tr');
                printWindow.document.write('<tr>' + tr.innerHTML + '</tr>');
            });

            printWindow.document.write('</table></body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">🏋️ Universal Gym - Payment Records 💰</h2>

        <button onclick="window.print()" class="btn btn-success mb-3">🖨️ Print All Records</button>
        <button onclick="printSelected()" class="btn btn-warning mb-3">🖨️ Print Selected</button>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Select</th>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Total Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><input type="checkbox" name="selectRow"></td>
                            <td><?= $row["id"] ?></td>
                            <td><?= $row["customer_name"] ?></td>
                            <td><?= $row["customer_email"] ?></td>
                            <td><?= $row["customer_address"] ?></td>
                            <td><?= ucfirst($row["payment_method"]) ?></td>
                            <td>₹<?= number_format($row["total_amount"], 2) ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">No payment records found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="admin_dashboard.php" class="btn btn-primary">🏠 Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
