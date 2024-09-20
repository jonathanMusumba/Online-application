<?php
session_start();
include 'db.php';
$sql = "SELECT logo, institution_name FROM settings LIMIT 1";
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

// Set the logo path
$logo = '../uploads/' . ($settings['logo'] ?? 'default_logo.webp');  // Set the default if no logo is found
$institution_name = $settings['institution_name'] ?? 'My Institution';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']); // email or phone number
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if the user exists by email or phone
    $sql = "SELECT * FROM users WHERE email='$identifier' OR phone_number='$identifier'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password_hash'])) {
            // Check if the user is verified
            if ($user['is_verified'] == 1) {
                // User is verified, start session and redirect to the dashboard
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['surname'] = $user['surname'];
                $_SESSION['other_names'] = $user['other_names'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect to the main dashboard
                header("Location: ../applicant/dashboard.php");
                exit;
            } else {
                // User is not verified, redirect to verify.php
                $_SESSION['temp_user_id'] = $user['id']; // Store user ID temporarily for verification check
                header("Location: verify.php");
                exit;
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email/phone!";
    }
    
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $institution_name; ?> - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            margin-top: 10px;
        }
        .logo img {
            max-width: 100px;
        }
        .links {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="login-container">
            <div class="text-center mb-4">
                <div class="logo mb-2">
                    <img src="<?php echo $logo; ?>" alt="Logo">
                </div>
                <h3><?php echo $institution_name; ?></h3>
            </div>
            <h4 class="text-center mb-4">Login</h4>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Email or Phone Number</label>
                    <input type="text" name="identifier" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>

            <div class="links mt-4">
                <span class="text-danger fw-bold">Did you forget your password?</span>
                <a href="forgot_password.php" class="btn btn-danger">
                    <strong>Click Here</strong>
                </a>
            </div>

            <div class="text-center mt-4">
                <a href="../index.php" class="btn btn-secondary btn-custom">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="how_to_apply.php" class="btn btn-outline-info btn-custom">
                    <i class="fas fa-info-circle"></i> How to Apply
                </a>
                <a href="../forms/registration.php" class="btn btn-outline-success btn-custom">
                    <i class="fas fa-user-plus"></i> Register Now
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>