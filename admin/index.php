<?php
session_start();
include 'db.php';

$sql = "SELECT logo, institution_name FROM settings LIMIT 1";
$result = mysqli_query($conn, $sql);
$settings = mysqli_fetch_assoc($result);

// Set the logo path
$logo = '../uploads/' . ($settings['logo'] ?? 'default_logo.webp');  // Set the default if no logo is found
$institution_name = $settings['institution_name'] ?? 'My Institution';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch the admin by email
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $admin['password_hash'])) {
            // Start the session and store admin information
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['first_name'] = $admin['first_name'];
            $_SESSION['last_name'] = $admin['last_name'];
            $_SESSION['role'] = $admin['role'];

            // Redirect to the admin dashboard
            header("Location: Dashboard.php");
            exit;
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No admin found with that email!";
    }
    
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
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
            <h3 class="text-center mb-4">Admin Login</h3>
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
        <div class="text-center mt-3">
                Did you forget your password? <a href="forgot-password.php" style="color: red; font-weight: bold;">Click Here</a>
            </div>
    </div>
</body>
</html>
