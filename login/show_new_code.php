<?php
session_start();

if (!isset($_SESSION['new_code']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$new_code = $_SESSION['new_code'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your New Verification Code</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card text-center">
            <div class="card-header">
                <h2>New Verification Code</h2>
            </div>
            <div class="card-body">
                <h3 class="card-title text-success">Your New Verification Code is:</h3>
                <h1 class="display-4 text-danger"><?php echo $new_code; ?></h1>
                <p class="card-text mt-4">Please note down your new verification code.</p>
                <form method="POST" action="verify_new_code.php">
                    <button type="submit" class="btn btn-primary btn-lg">Proceed</button>
                </form>
            </div>
            <div class="card-footer text-muted">
                You will be asked to enter this code on the next page.
            </div>
        </div>
    </div>
</body>
</html>
