<?php
include 'db.php';
$sql = "SELECT logo, institution_name FROM settings LIMIT 1";
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

// Set the logo path
$logo = '../uploads/' . $settings['logo'] ?? '../uploads/default_logo.webp';  // Set the default if no logo is found
$institution_name = $settings['institution_name'] ?? 'My Institution';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wrong Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .error-container {
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
            color: #dc3545;
        }
        .text-center p {
            color: #6c757d;
        }
        .btn {
            margin-top: 1rem;
        }
        .back-to-login {
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-to-login i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="error-container">
            <div class="text-center mb-4">
                <div class="logo mb-2">
                    <!-- Display the logo dynamically -->
                    <img src="<?php echo $logo; ?>" alt="Logo">
                </div>
                <h3><?php echo $institution_name; ?></h3>
            </div>
            <h2 class="text-center text-danger">Wrong Verification Code</h2>
            <p class="text-center">It seems the verification code you entered was incorrect. Please request a new one.</p>
            <form action="generate_code.php" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Email or Phone Number</label>
                    <input type="text" name="identifier" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Request New Code</button>
            </form>
            <div class="back-to-login text-center mt-3">
                <a href="login.php" class="btn btn-link"><i class="fas fa-home"></i> Back to Login</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
