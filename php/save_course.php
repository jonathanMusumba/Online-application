<?php
// Database connection
include('../connection/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $course_type = mysqli_real_escape_string($conn, $_POST['course_type']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $tuition = mysqli_real_escape_string($conn, $_POST['tuition']);
    $minimum_requirements = mysqli_real_escape_string($conn, $_POST['requirements']);

    // Insert into the database
    $query = "INSERT INTO courses (course_name, course_code, course_type, duration, tuition, minimum_requirements) 
              VALUES ('$course_name', '$course_code', '$course_type', '$duration', '$tuition', '$minimum_requirements')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Course added successfully'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='index.php';</script>";
    }
}
?>
