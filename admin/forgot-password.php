<?php
session_start();
include 'db.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);

    // Check if identifier is an email or phone
    $sql = "SELECT * FROM admin WHERE email='$identifier' OR phone='$identifier'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $verification_code = rand(100000, 999999); // Generate a 6-digit code
        $token = bin2hex(random_bytes(16)); // Generate a secure token

        // Store verification code and token in session
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['token'] = $token;
        $_SESSION['user_id'] = $user['id']; // Store user ID for later

        // For demo purposes, display the verification code
        echo "Verification code: $verification_code"; // In production, don't display this
        echo "<br><a href='verify_code.php'>Continue to verify</a>";
    } else {
        echo "No user found with that email or phone number!";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Forgot Password</h2>
        <form id="forgotPasswordForm" method="POST" action="forgot-password.php">
            <div class="mb-3">
                <label for="identifier" class="form-label">Email or Phone Number</label>
                <input type="text" id="identifier" name="identifier" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
