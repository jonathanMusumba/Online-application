<?php
include 'db.php';
include 'functions.php'; // Ensure the generateVerificationCode function is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email='$identifier' OR phone_number='$identifier'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];

        // Generate a new 4-letter verification code
        $new_code = generateVerificationCode();

        // Update the verification code in the database
        $update_sql = "UPDATE users SET verification_code='$new_code' WHERE id='$user_id'";
        mysqli_query($conn, $update_sql);

        // Store the new code and user ID in session for the next page
        session_start();
        $_SESSION['new_code'] = $new_code;
        $_SESSION['user_id'] = $user_id;

        // Redirect to show the new code page
        header("Location: show_new_code.php");
        exit;
    } else {
        echo "No user found with that email/phone!";
    }
}
?>
