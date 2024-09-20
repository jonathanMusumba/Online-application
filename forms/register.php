<?php
// Include the database connection file
include 'db.php';

// Function to generate a random 4-letter code excluding 'I' and 'O'
function generateVerificationCode() {
    $letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    return substr(str_shuffle($letters), 0, 4);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $other_names = mysqli_real_escape_string($conn, $_POST['other_names']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Password validation
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Generate a 4-letter verification code
    $verification_code = generateVerificationCode();

    // Insert the user data into the database
    $sql = "INSERT INTO users (surname, other_names, sex, dob, phone_number, email, district_id, nationality_id, password_hash, verification_code) 
            VALUES ('$surname', '$other_names', '$sex', '$dob', '$phone_number', '$email', '$district', '$nationality', '$password_hash', '$verification_code')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to registration success page
        header("Location: registration_success.php?verification_code=" . urlencode($verification_code));
        exit;
    } else {
        // Handle errors
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
