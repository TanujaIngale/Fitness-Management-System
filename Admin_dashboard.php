<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fullscreen Background */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('images/hero-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            text-align: center;
        }

        /* Top Spacing */
        .dashboard-container {
            margin-top: 50px; /* Adds space from the top */
        }

        /* Title Styling */
        .title {
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Dashboard Card Styling */
        .dashboard-card {
            width: 100%;
            max-width: 350px; /* Ensures cards are not too wide */
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            text-align: center;
            margin: 10px auto; /* Center the cards */
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <h1 class="title mt-4">Universal Fitness Club</h1>
        <h2 class="mb-4">Admin Reports</h2>

        <!-- Centered Cards (2 per row) -->
        <div class="container dashboard-container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="dashboard-card">
                        <h4>Total Inquiries</h4>
                        <h2 id="totalInquiries">Loading...</h2>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="dashboard-card">
                        <h4>Morning Batch Members</h4>
                        <h2 id="morningBatchTotal">Loading...</h2>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="dashboard-card">
                        <h4>Evening Batch Members</h4>
                        <h2 id="eveningBatchTotal">Loading...</h2>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="dashboard-card">
                        <h4>Admins</h4>
                        <h2 id="totalSignups">Loading...</h2>
						<a href="view_admin_payments.php" class="btn btn-light mt-2">View</a> 
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="dashboard-card">
                        <h4>Completed Orders</h4>
                        <h2 id="completedPayments">Loading...</h2>
						<a href="view_payments.php" class="btn btn-light mt-2">View</a> 

                    </div>
					
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch data for different sections
        fetch('get_total_inquiries.php')
            .then(response => response.text())
            .then(data => document.getElementById('totalInquiries').innerText = data)
            .catch(error => console.error('Error fetching total inquiries:', error));

        fetch('get_morning_batch_count.php')
            .then(response => response.text())
            .then(data => document.getElementById('morningBatchTotal').innerText = data)
            .catch(error => console.error('Error fetching morning batch count:', error));

        fetch('get_evening_batch_count.php')
            .then(response => response.text())
            .then(data => document.getElementById('eveningBatchTotal').innerText = data)
            .catch(error => console.error('Error fetching evening batch count:', error));

        fetch('get_total_signups.php')
            .then(response => response.text())
            .then(data => document.getElementById('totalSignups').innerText = data)
            .catch(error => console.error('Error fetching total signups:', error));

        fetch('get_completed_payments.php')
            .then(response => response.text())
            .then(data => document.getElementById('completedPayments').innerText = data)
            .catch(error => console.error('Error fetching completed payments:', error));
    </script>
</body>
</html>
