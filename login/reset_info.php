<?php
include 'db.php';

// Fetch logo and institution name
$sql = "SELECT logo, institution_name FROM settings LIMIT 1";
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

// Set the logo path
$logo = '../uploads/' . ($settings['logo'] ?? 'default_logo.webp');  // Set the default if no logo is found
$institution_name = $settings['institution_name'] ?? 'My Institution';

$short_code = htmlspecialchars($_GET['code'] ?? '');

if (empty($short_code)) {
    echo "<p class='text-danger'>No short code provided!</p>";
    exit;
}

// Fetch the reset token based on the short code
$sql = "SELECT reset_token FROM users WHERE reset_code='$short_code'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<p class='text-danger'>Invalid short code!</p>";
    exit;
}

$full_token = $user['reset_token'];
$reset_link = "http://yourwebsite.com/reset_password.php?token=" . $full_token;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .reset-info-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo img {
            max-width: 100px;
        }
        .text-center h2 {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="reset-info-container">
            <div class="text-center mb-4">
                <div class="logo mb-2">
                    <!-- Display the logo dynamically -->
                    <img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo">
                </div>
                <h3><?php echo htmlspecialchars($institution_name); ?></h3>
            </div>
            <h2 class="text-center">Reset Information</h2>
            <p class="text-center">Use the following reset link and code to reset your password:</p>
            <p class="text-center"><strong>Reset Link:</strong> <a href="<?php echo htmlspecialchars($reset_link); ?>"><?php echo htmlspecialchars($reset_link); ?></a></p>
            <p class="text-center"><strong>Short Code:</strong> <?php echo htmlspecialchars($short_code); ?></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
