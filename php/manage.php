<?php
// Database connection
include('../connection/db.php');

// Fetch courses
$query = "SELECT * FROM courses";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-4">
        <h1 class="mb-4">Courses</h1>

        <!-- Success/Error Message -->
        <div id="message" class="alert" style="display: none;"></div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Course Code</th>
                    <th>Course Type</th>
                    <th>Duration</th>
                    <th>Tuition</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($course = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['id']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_type']); ?></td>
                    <td><?php echo htmlspecialchars($course['duration']); ?></td>
                    <td><?php echo htmlspecialchars($course['Tuition']); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCourseModal" data-id="<?php echo $course['id']; ?>" data-name="<?php echo htmlspecialchars($course['course_name']); ?>" data-code="<?php echo htmlspecialchars($course['course_code']); ?>" data-type="<?php echo htmlspecialchars($course['course_type']); ?>" data-duration="<?php echo htmlspecialchars($course['duration']); ?>" data-tuition="<?php echo htmlspecialchars($course['Tuition']); ?>" data-requirements="<?php echo htmlspecialchars($course['minimum_requirements']); ?>">Edit</button>
                        <!-- Delete Button -->
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $course['id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCourseForm" method="POST" action="edit_course.php">
                        <input type="hidden" name="id" id="courseId">
                        <div class="mb-3">
                            <label for="course_name" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="course_code" class="form-label">Course Code</label>
                            <input type="text" class="form-control" id="course_code" name="course_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="course_type" class="form-label">Course Type</label>
                            <select class="form-select" id="course_type" name="course_type" required>
                                <option value="Certificate">Certificate</option>
                                <option value="Diploma Direct">Diploma Direct</option>
                                <option value="Diploma Extension">Diploma Extension</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (Years)</label>
                            <input type="number" step="0.1" class="form-control" id="duration" name="duration" required>
                        </div>
                        <div class="mb-3">
                            <label for="tuition" class="form-label">Tuition per Semester</label>
                            <input type="number" step="0.01" class="form-control" id="tuition" name="tuition" required>
                        </div>
                        <div class="mb-3">
                            <label for="requirements" class="form-label">Minimum Requirements</label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Populate modal fields when edit button is clicked
    document.addEventListener('DOMContentLoaded', function() {
        var editCourseModal = document.getElementById('editCourseModal');
        editCourseModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; 
            var courseId = button.getAttribute('data-id');
            var courseName = button.getAttribute('data-name');
            var courseCode = button.getAttribute('data-code');
            var courseType = button.getAttribute('data-type');
            var duration = button.getAttribute('data-duration');
            var tuition = button.getAttribute('data-tuition');
            var requirements = button.getAttribute('data-requirements');

            var modal = editCourseModal.querySelector('form');
            modal.querySelector('#courseId').value = courseId;
            modal.querySelector('#course_name').value = courseName;
            modal.querySelector('#course_code').value = courseCode;
            modal.querySelector('#course_type').value = courseType;
            modal.querySelector('#duration').value = duration;
            modal.querySelector('#tuition').value = tuition;
            modal.querySelector('#requirements').value = requirements;
        });
    });

    // Confirm deletion
    function confirmDelete(courseId) {
        if (confirm('Are you sure you want to delete this course?')) {
            window.location.href = 'delete_course.php?id=' + courseId;
        }
    }

    // Display messages
    function showMessage(type, message) {
        var messageDiv = document.getElementById('message');
        messageDiv.className = 'alert alert-' + type;
        messageDiv.textContent = message;
        messageDiv.style.display = 'block';
    }

    // Example usage
    <?php if (isset($_GET['status'])) { ?>
        showMessage('<?php echo $_GET['status']; ?>', '<?php echo $_GET['message']; ?>');
    <?php } ?>
    </script>
</body>
</html>
