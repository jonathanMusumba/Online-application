<?php
// Database connection
include('../connection/db.php');

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $course_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the course from the database
    $delete_query = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $course_id);

    if ($stmt->execute()) {
        // Success message
        header("Location: index.php?status=success&message=Course deleted successfully");
    } else {
        // Error message
        header("Location: index.php?status=error&message=Failed to delete course");
    }

    $stmt->close();
} else {
    // Redirect if no ID is provided
    header("Location: index.php?status=error&message=Invalid course ID");
}

$conn->close();
?>
