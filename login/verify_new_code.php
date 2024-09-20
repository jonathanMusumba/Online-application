<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verification_code = mysqli_real_escape_string($conn, $_POST['verification_code']);
    $user_id = $_SESSION['user_id'];

    // Check if the verification code is correct
    $sql = "SELECT * FROM users WHERE id='$user_id' AND verification_code='$verification_code'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Set is_verified to 1
        $update_sql = "UPDATE users SET is_verified = 1 WHERE id = '$user_id'";
        mysqli_query($conn, $update_sql);

        // Start the session and set necessary user info
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['other_names'] = $user['other_names'];
        $_SESSION['sex'] = $user['sex'];
        $_SESSION['dob'] = $user['dob'];
        $_SESSION['phone_number'] = $user['phone_number'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['district_id'] = $user['district_id'];
        $_SESSION['nationality_id'] = $user['nationality_id'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Verification failed
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
    <title>Verify Your New Code</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card text-center">
            <div class="card-header">
                <h2>Enter Verification Code</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="verification_code" class="form-label">Enter the verification code you received</label>
                        <input type="text" class="form-control" id="verification_code" name="verification_code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Verify</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
