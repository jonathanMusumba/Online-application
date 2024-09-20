<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $user_id = $_SESSION['user_id'];

        // Update password in database
        $sql = "UPDATE admin SET password_hash='$hashed_password' WHERE id='$user_id'";
        if (mysqli_query($conn, $sql)) {
            echo "Password reset successful!";
            session_unset(); // Clear session
            session_destroy(); // End session
            // Optionally redirect to login page
            echo "<a href='index.php'>Login</a>";
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Passwords do not match.";
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        .strength-indicator {
            height: 5px;
            width: 100%;
            background-color: lightgrey;
            margin-top: 5px;
            transition: width 0.5s;
        }
        .weak { background-color: red; }
        .medium { background-color: orange; }
        .strong { background-color: green; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Reset Password</h2>
        <form id="resetForm" method="POST">
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
                <div id="strengthIndicator" class="strength-indicator"></div>
                <small id="passwordMessage" class="form-text text-muted"></small>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" disabled>Reset Password</button>
        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('new_password');
        const confirmInput = document.getElementById('confirm_password');
        const strengthIndicator = document.getElementById('strengthIndicator');
        const passwordMessage = document.getElementById('passwordMessage');

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            const strength = getPasswordStrength(password);
            updateStrengthIndicator(strength);
            validatePassword(password, confirmInput.value);
        });

        confirmInput.addEventListener('input', () => {
            validatePassword(passwordInput.value, confirmInput.value);
        });

        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[\W_]/.test(password)) strength++;
            return strength;
        }

        function updateStrengthIndicator(strength) {
            strengthIndicator.className = 'strength-indicator';
            if (strength === 1) {
                strengthIndicator.classList.add('weak');
                strengthIndicator.style.width = '20%';
                passwordMessage.innerText = "Weak password.";
            } else if (strength === 2) {
                strengthIndicator.classList.add('medium');
                strengthIndicator.style.width = '50%';
                passwordMessage.innerText = "Medium password.";
            } else if (strength >= 3) {
                strengthIndicator.classList.add('strong');
                strengthIndicator.style.width = '100%';
                passwordMessage.innerText = "Strong password.";
            } else {
                strengthIndicator.style.width = '0';
                passwordMessage.innerText = "";
            }
        }

        function validatePassword(password, confirmPassword) {
            const isValid = password.length >= 8 && 
                            /[A-Z]/.test(password) && 
                            /[a-z]/.test(password) && 
                            /[0-9]/.test(password) && 
                            /[\W_]/.test(password) && 
                            password === confirmPassword;
            document.querySelector('button[type="submit"]').disabled = !isValid;
        }
    </script>
</body>
</html>
