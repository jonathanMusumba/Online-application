<?php
// Database connection
include('../connection/db.php');

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = mysqli_real_escape_string($conn, $_POST['id']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $course_type = mysqli_real_escape_string($conn, $_POST['course_type']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $tuition = mysqli_real_escape_string($conn, $_POST['tuition']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);

    // Update course details in the database
    $update_query = "UPDATE courses SET course_name = ?, course_code = ?, course_type = ?, duration = ?, Tuition = ?, minimum_requirements = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('sssdsdi', $course_name, $course_code, $course_type, $duration, $tuition, $requirements, $course_id);

    if ($stmt->execute()) {
        // Success message
        header("Location: index.php?status=success&message=Course updated successfully");
    } else {
        // Error message
        header("Location: index.php?status=error&message=Failed to update course");
    }

    $stmt->close();
} else {
    // Redirect if not POST request
    header("Location: index.php?status=error&message=Invalid request");
}

$conn->close();
?>
