<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}
$applicant_name = $_SESSION['surname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            padding: 15px;
            color: white;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center text-white">Applicant Dashboard</h4>
        <a href="applicant_dashboard.php">Home</a>
        <a href="application_status.php">My Application</a>
        <a href="upload_documents.php">Upload Documents</a>
        <a href="payment_details.php">Payment Details</a>
        <a href="notifications.php">Notifications</a>
        <a href="applicant_settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h3>Welcome, <?php echo $applicant_name; ?>!</h3>
        </div>

        <div class="container mt-4">
            <h5>Dashboard Overview</h5>
            <p>Here you can manage your application, upload documents, check notifications, and more.</p>

            <!-- Dynamic content -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Application Status</h5>
                            <p class="card-text">View and manage your application details.</p>
                            <a href="application_status.php" class="btn btn-primary">Go to Application</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Upload Documents</h5>
                            <p class="card-text">Upload required documents for your application.</p>
                            <a href="upload_documents.php" class="btn btn-primary">Upload</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Payment Details</h5>
                            <p class="card-text">Check payment information and status.</p>
                            <a href="payment_details.php" class="btn btn-primary">View Payments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
