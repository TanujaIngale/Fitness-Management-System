<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Enquiries</title>
    <style>
        body {
            background-image: url('images/trainer-bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(0, 0, 0, 0.7);
        }
        th, td {
            color: white;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #333;
        }
        .print-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .print-btn:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function printSelected() {
            let selectedRows = document.querySelectorAll("input[name='printSelect']:checked");
            if (selectedRows.length === 0) {
                alert("Please select at least one record to print.");
                return;
            }

            let printContents = "<table border='1' cellpadding='10' cellspacing='0'><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th></tr>";
            
            selectedRows.forEach(row => {
                let tr = row.closest("tr");
                printContents += "<tr>" + tr.innerHTML.replace(/<td><input[^>]+><\/td>/, "") + "</tr>"; // Remove checkbox column
            });

            printContents += "</table>";

            let originalContents = document.body.innerHTML;
            document.body.innerHTML = "<html><head><title>Print</title></head><body>" + printContents + "</body></html>";
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // Refresh to restore checkboxes
        }
    </script>
</head>
<body>
    <h2 style="color: white;">Universal Fitness Club</h2>
	<h2 style="color: white;">Gym Enquiries</h2>

    <?php
    $servername = "localhost";
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "gym"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Run the query to fetch data
    $sql = "SELECT id, name, email, phone, message FROM contact_messages";
    $result = $conn->query($sql);

    // Check if there are records to display
    if ($result->num_rows > 0) {
        echo "<table id='enquiryTable'>";
        echo "<tr><th>Select</th><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th></tr>";
        
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='printSelect'></td>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['message'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<button class='print-btn' onclick='printSelected()'>Print Selected</button>";
    } else {
        echo "<p style='color: white;'>No records found.</p>";
    }

    // Close connection
    $conn->close();
    ?>

</body>
</html>
