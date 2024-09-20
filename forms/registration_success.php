<?php
// Include the database connection file
include 'db.php';

// Get the verification code from the URL
$verification_code = isset($_GET['verification_code']) ? mysqli_real_escape_string($conn, $_GET['verification_code']) : '';

// Fetch institution name from settings table
$query = "SELECT institution_name FROM settings LIMIT 1";
$result = mysqli_query($conn, $query);
$institution_name = mysqli_fetch_assoc($result)['institution_name'];

// Fetch the user's data to display
$sql = "SELECT surname, other_names, sex, nationality_id, district_id FROM users WHERE verification_code = '$verification_code'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Fetch nationality and district names
$query_nationality = "SELECT country_name FROM countries WHERE id = " . $user['nationality_id'];
$query_district = "SELECT Name FROM district WHERE id = " . $user['district_id'];

$result_nationality = mysqli_query($conn, $query_nationality);
$result_district = mysqli_query($conn, $query_district);

$nationality = mysqli_fetch_assoc($result_nationality)['country_name'];
$district = mysqli_fetch_assoc($result_district)['Name'];

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registration Successful</h2>
        <p class="text-center">Thank you for registering with us!</p>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Registration Details</h5>
                <p><strong>Institution Name:</strong> <?php echo htmlspecialchars($institution_name); ?></p>
                <p><strong>Surname:</strong> <?php echo htmlspecialchars($user['surname']); ?></p>
                <p><strong>Other Names:</strong> <?php echo htmlspecialchars($user['other_names']); ?></p>
                <p><strong>Sex:</strong> <?php echo htmlspecialchars($user['sex']); ?></p>
                <p><strong>Nationality:</strong> <?php echo htmlspecialchars($nationality); ?></p>
                <p><strong>District of Residence:</strong> <?php echo htmlspecialchars($district); ?></p>
                <p><strong>Your Verification Code is:</strong> <?php echo htmlspecialchars($verification_code); ?></p>
                <p><strong>Password:</strong> <em>Not displayed for security reasons</em></p>
                <p class="text-danger">Note: Please note down your Verification Code and Password.</p>
                <a class="btn btn-primary" href="login.php">Continue to Login</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
