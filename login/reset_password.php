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
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $new_password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        echo "<p class='text-danger'>Passwords do not match!</p>";
        exit;
    }

    // Hash the new password
    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    // Check if the token is valid and not expired
    $sql = "SELECT * FROM users WHERE reset_token='$token' AND token_expires_at > NOW()";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Update password
        $sql = "UPDATE users SET password_hash='$password_hash', reset_token=NULL, token_expires_at=NULL WHERE reset_token='$token'";
        if (mysqli_query($conn, $sql)) {
            echo "<p class='text-success'>Password reset successful!</p>";
            header("Location: login.php");
            exit;
        } else {
            echo "<p class='text-danger'>Error resetting password!</p>";
        }
    } else {
        echo "<p class='text-danger'>Invalid or expired token!</p>";
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .reset-password-container {
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
        <div class="reset-password-container">
            <div class="text-center mb-4">
                <div class="logo mb-2">
                    <!-- Display the logo dynamically -->
                    <img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo">
                </div>
                <h3><?php echo htmlspecialchars($institution_name); ?></h3>
            </div>
            <h2 class="text-center">Reset Password</h2>
            <form action="reset_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
