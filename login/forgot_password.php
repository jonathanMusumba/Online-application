<?php
include 'db.php';

// Fetch logo and institution name
$sql = "SELECT logo, institution_name FROM settings LIMIT 1";
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

// Set the logo path
$logo = '../uploads/' . ($settings['logo'] ?? 'default_logo.webp');  // Set the default if no logo is found
$institution_name = $settings['institution_name'] ?? 'My Institution';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
    
    // Check if the user exists
    $sql = "SELECT * FROM users WHERE email='$identifier' OR phone_number='$identifier'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Generate a full-length token and a short code
        $full_token = bin2hex(random_bytes(50));
        $short_code = substr(str_shuffle('0123456789ABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 4);

        $user = mysqli_fetch_assoc($result);
        $email = $user['email'];
        
        // Store the token and short code, with expiry set to 30 minutes from now
        $sql = "UPDATE users SET reset_token='$full_token', reset_code='$short_code', token_expires_at=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE email='$email'";
        mysqli_query($conn, $sql);

        // Redirect to the page showing the reset link and short code
        header("Location: reset_info.php?code=$short_code");
        exit;
    } else {
        echo "<p class='text-danger'>No user found with that email/phone!</p>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .forgot-password-container {
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
        <div class="forgot-password-container">
            <div class="text-center mb-4">
                <div class="logo mb-2">
                    <!-- Display the logo dynamically -->
                    <img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo">
                </div>
                <h3><?php echo htmlspecialchars($institution_name); ?></h3>
            </div>
            <h2 class="text-center">Forgot Password</h2>
            <form action="forgot_password.php" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Email or Phone Number</label>
                    <input type="text" name="identifier" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Send Reset Link</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
