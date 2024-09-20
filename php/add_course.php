<?php
// Database connection
include('../connection/db.php');


$institution_query = "SELECT institution_name FROM settings LIMIT 1";
$institution_result = mysqli_query($conn, $institution_query);
$institution_name = mysqli_fetch_assoc($institution_result)['institution_name'];

// Fetch courses from the courses table
$courses_query = "SELECT * FROM courses";
$courses_result = mysqli_query($conn, $courses_query);
$courses = [];
while($row = mysqli_fetch_assoc($courses_result)) {
    $courses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course - <?php echo $institution_name; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-info .logout {
            margin-left: auto;
        }
        .header-info .current-date-time {
            margin-right: 20px;
        }
        .breadcrumb {
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-dark text-white p-3">
        <div class="container header-info">
            <div class="d-flex align-items-center">
                <h1 class="me-3"><?php echo $institution_name; ?></h1>
                <div class="current-date-time">
                    <span id="currentDateTime"></span>
                </div>
                <a href="logout.php" class="btn btn-outline-light logout">Logout</a>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Course</li>
        </ol>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <!-- Add Course Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add New Course</h5>
            </div>
            <div class="card-body">
                <form action="save_course.php" method="POST">
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
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        </div>

        <!-- Courses Data View -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Courses List</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Course Type</th>
                            <th>Duration (Years)</th>
                            <th>Tuition</th>
                             <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $index => $course) { ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                                <td><?php echo htmlspecialchars($course['course_type']); ?></td>
                                <td><?php echo htmlspecialchars($course['duration']); ?></td>
                                <td><?php echo number_format($course['Tuition'], 2); ?></td>
                                <td>
                                    <!-- Edit Button with Font Awesome Icon and Tooltip -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCourseModal"
                                            data-id="<?php echo $course['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($course['course_name']); ?>"
                                            data-code="<?php echo htmlspecialchars($course['course_code']); ?>"
                                            data-type="<?php echo htmlspecialchars($course['course_type']); ?>"
                                            data-duration="<?php echo htmlspecialchars($course['duration']); ?>"
                                            data-tuition="<?php echo htmlspecialchars($course['Tuition']); ?>"
                                            title="Edit Course" data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Delete Button with Font Awesome Icon and Tooltip -->
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $course['id']; ?>)"
                                            title="Delete Course" data-bs-toggle="tooltip">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
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
                    
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
        // Display current date and time
        function updateDateTime() {
            const now = new Date();
            document.getElementById('currentDateTime').innerText = now.toLocaleString();
        }
        setInterval(updateDateTime, 1000); // Update every second
        updateDateTime(); // Initial call
        document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
    </script>
</body>
</html>
