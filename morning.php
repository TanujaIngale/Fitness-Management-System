<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Members Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .selected {
            background-color: #e0e0e0;
        }
        .button {
            margin: 5px;
            padding: 6px 10px;
            cursor: pointer;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .print-button { background-color: #007bff; }
        .edit-button { background-color: #28a745; }
        .delete-button { background-color: #dc3545; }
    </style>
    <script>
        function toggleRowSelection(checkbox) {
            let row = checkbox.closest('tr');
            row.classList.toggle('selected', checkbox.checked);
        }

        function printTable() {
            const selectedRows = document.querySelectorAll('tr.selected');
            if (selectedRows.length === 0) {
                alert("No rows selected for printing.");
                return;
            }

            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Print Selected</title>');
            printWindow.document.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }</style>');
            printWindow.document.write('</head><body>');
			printWindow.document.write('<h2 style="text-align: center;"><strong>Universal Fitness Club</strong></h2>');
            printWindow.document.write('<h2>Selected Members</h2>');
            printWindow.document.write('<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Date of Birth</th><th>Batch</th><th>Membership Plan</th><th>Payment Method</th><th>Payment Amount</th></tr>');

            selectedRows.forEach(row => {
                const cells = row.querySelectorAll('td:not(:last-child)');
                printWindow.document.write('<tr>');
                cells.forEach(cell => {
                    printWindow.document.write('<td>' + cell.innerHTML + '</td>');
                });
                printWindow.document.write('</tr>');
            });

            printWindow.document.write('</table></body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function editRow(button) {
            let row = button.closest('tr');
            let cells = row.querySelectorAll('td[data-field]');
            let memberId = row.getAttribute('data-id');

            cells.forEach(cell => {
                let fieldName = cell.getAttribute('data-field');
                let value = cell.innerText;
                cell.innerHTML = `<input type="text" value="${value}" name="${fieldName}">`;
            });

            button.innerText = "Save";
            button.onclick = () => saveChanges(button, memberId);
        }

        function saveChanges(button, memberId) {
            let row = button.closest('tr');
            let inputs = row.querySelectorAll('input');
            let formData = new FormData();

            formData.append("id", memberId);
            inputs.forEach(input => {
                formData.append(input.name, input.value);
            });

            fetch('update_member.php', {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    inputs.forEach(input => {
                        let parent = input.parentNode;
                        parent.innerText = input.value;
                    });

                    button.innerText = "Edit";
                    button.onclick = () => editRow(button);
                    alert("Member info updated successfully!");
                } else {
                    alert("Error updating member info.");
                }
            })
            .catch(error => console.error("Error:", error));
        }

        function deleteRow(button, memberId) {
            if (confirm("Are you sure you want to delete this member?")) {
                fetch('delete_member.php', {
                    method: "POST",
                    body: JSON.stringify({ id: memberId }),
                    headers: { "Content-Type": "application/json" }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.closest('tr').remove();
                        alert("Member deleted successfully!");
                    } else {
                        alert("Error deleting member.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }
    </script>
</head>
<body>
	
    <h2>Morning Batch Members List</h2>

    <button class="button print-button" onclick="printTable()">Print Selected</button>

    <table>
        <tr>
            <th>Select</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date of Birth</th>
            <th>Batch</th>
            <th>Membership Plan</th>
            <th>Payment Method</th>
            <th>Payment Amount</th>
            <th>Actions</th>
        </tr>

        <?php
        $conn = new mysqli("localhost", "root", "", "gym");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM members WHERE select_batch = 'mrg'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row['id'] . "'>
                        <td><input type='checkbox' onclick='toggleRowSelection(this)'></td>
                        <td data-field='first_name'>" . htmlspecialchars($row['first_name']) . "</td>
                        <td data-field='last_name'>" . htmlspecialchars($row['last_name']) . "</td>
                        <td data-field='email'>" . htmlspecialchars($row['email']) . "</td>
                        <td data-field='phone'>" . htmlspecialchars($row['phone']) . "</td>
                        <td data-field='dob'>" . htmlspecialchars($row['dob']) . "</td>
                        <td data-field='select_batch'>" . htmlspecialchars($row['select_batch']) . "</td>
                        <td data-field='membership_plan'>" . htmlspecialchars($row['membership_plan']) . "</td>
                        <td data-field='payment_method'>" . htmlspecialchars($row['payment_method']) . "</td>
                        <td data-field='payment_amount'>" . htmlspecialchars($row['payment_amount']) . "</td>
                        <td>
                            <button class='button edit-button' onclick='editRow(this)'>Edit</button>
                            <button class='button delete-button' onclick='deleteRow(this, " . $row['id'] . ")'>Delete</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No records found</td></tr>";
        }

        $conn->close();
        ?>

    </table>
</body>
</html>
