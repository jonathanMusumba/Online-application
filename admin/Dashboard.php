<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$admin_name = $_SESSION['first_name'];
$admin_role = $_SESSION['role']; // Get the role from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $admin_role; ?> Dashboard</title>
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
            background-color: #28a745;
            padding: 15px;
            color: white;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center text-white"><?php echo $admin_role; ?> Dashboard</h4>
        
        <a href="admin_dashboard.php">Home</a>
        
        <!-- Show options based on the role -->
        <?php if ($admin_role == 'Admin' || $admin_role == 'Principal') : ?>
            <a href="manage_applicants.php">Manage Applicants</a>
            <a href="verify_documents.php">Verify Documents</a>
        <?php endif; ?>
        
        <?php if ($admin_role == 'Admin' || $admin_role == 'Accountant') : ?>
            <a href="approve_payments.php">Approve Payments</a>
            <a href="payment_reports.php">Payment Reports</a>
        <?php endif; ?>

        <?php if ($admin_role == 'Support') : ?>
            <a href="support_queries.php">Respond to Queries</a>
            <a href="reset_passwords.php">Reset Passwords</a>
        <?php endif; ?>
        
        <?php if ($admin_role == 'Admin') : ?>
            <a href="admin_settings.php">Settings</a>
        <?php endif; ?>
        
        <a href="admin_notifications.php">Notifications</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h3>Welcome, <?php echo $admin_name; ?>!</h3>
        </div>

        <div class="container mt-4">
            <h5>Dashboard Overview</h5>
            
            <!-- Content changes based on role -->
            <?php if ($admin_role == 'Admin' || $admin_role == 'Principal') : ?>
                <p>Manage applicants, verify documents, and generate reports.</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Manage Applicants</h5>
                                <p class="card-text">View, edit, approve, or reject applications.</p>
                                <a href="manage_applicants.php" class="btn btn-success">Manage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Verify Documents</h5>
                                <p class="card-text">Check and verify submitted documents.</p>
                                <a href="verify_documents.php" class="btn btn-success">Verify</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($admin_role == 'Admin' || $admin_role == 'Accountant') : ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Approve Payments</h5>
                                <p class="card-text">Review and approve payments made by applicants.</p>
                                <a href="approve_payments.php" class="btn btn-success">Approve</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Payment Reports</h5>
                                <p class="card-text">Review payment history and generate reports.</p>
                                <a href="payment_reports.php" class="btn btn-success">View Reports</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($admin_role == 'Support') : ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Respond to Queries</h5>
                                <p class="card-text">Respond to support queries from applicants.</p>
                                <a href="support_queries.php" class="btn btn-success">Respond</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Reset Passwords</h5>
                                <p class="card-text">Handle password reset requests.</p>
                                <a href="reset_passwords.php" class="btn btn-success">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
