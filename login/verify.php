<?php
session_start();
include 'db.php';

if (!isset($_SESSION['temp_user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verification_code = mysqli_real_escape_string($conn, $_POST['verification_code']);
    $user_id = $_SESSION['temp_user_id'];

    // Fetch the user
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // Check if verification code is correct
    if ($user['verification_code'] == $verification_code) {
        // Update is_verified to 1
        $update_sql = "UPDATE users SET is_verified = 1 WHERE id='$user_id'";
        mysqli_query($conn, $update_sql);

        // Start the session with user info
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['other_names'] = $user['other_names'];
        $_SESSION['email'] = $user['email'];
        
        // Unset temporary session
        unset($_SESSION['temp_user_id']);
        
        // Redirect to dashboard
        header("Location:../applicant/dashboard.php");
        exit;
    } else {
        // Redirect to wrong verification page
        header("Location: wrong_verification.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .verify-code-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="verify-code-container">
            <h2 class="text-center">Verify Your Code</h2>
            <form action="verify.php" method="POST">
                <div class="mb-3">
                    <label for="verification_code" class="form-label">Verification Code</label>
                    <input type="text" name="verification_code" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Verify</button>
            </form>
            <p class="mt-3 text-center"><a href="resend_verification.php">Resend Verification Code</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
