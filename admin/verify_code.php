<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['code'];

    if (isset($_SESSION['verification_code']) && isset($_SESSION['token'])) {
        if ($entered_code == $_SESSION['verification_code']) {
            // Code is correct, proceed to allow password reset
            echo "Verification successful! You can now reset your password.";
            echo "<form method='POST' action='reset-password.php'>
                    <input type='password' name='new_password' placeholder='New Password' required>
                    <input type='password' name='confirm_password' placeholder='Confirm Password' required>
                    <button type='submit'>Reset Password</button>
                  </form>";
        } else {
            echo "Invalid verification code.";
        }
    } else {
        echo "Session expired. Please restart the process.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Code</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Verify Code</h2>
        <form id="verificationForm" method="POST" action="verify_code.php">
            <div class="mb-3">
                <label for="code" class="form-label">Verification Code</label>
                <input type="text" id="code" name="code" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify Code</button>
        </form>
    </div>
</body>
</html>
