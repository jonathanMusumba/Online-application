<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sticky-header {
            position: -webkit-sticky; /* For Safari */
            position: sticky;
            top: 0;
            z-index: 1020;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }
        .form-container {
            margin-top: 60px; /* Adjust based on header height */
        }
        .form-control.error {
            border-color: #dc3545;
        }
        .form-text {
            color: #dc3545;
        }
    </style>
    <script>
        function validateForm() {
            const surname = document.getElementById('surname').value;
            const otherNames = document.getElementById('other_names').value;
            const phoneNumber = document.getElementById('phone_number').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            let valid = true;

            // Name validation
            const namePattern = /^[A-Za-z.]+$/;
            if (!namePattern.test(surname)) {
                document.getElementById('surname').classList.add('error');
                valid = false;
            } else {
                document.getElementById('surname').classList.remove('error');
            }
            
            if (!namePattern.test(otherNames)) {
                document.getElementById('other_names').classList.add('error');
                valid = false;
            } else {
                document.getElementById('other_names').classList.remove('error');
            }

            // Phone number validation
            const phonePattern = /^0\d{9}$|^\d{9}$/;
            if (!phonePattern.test(phoneNumber)) {
                document.getElementById('phone_number').classList.add('error');
                valid = false;
            } else {
                document.getElementById('phone_number').classList.remove('error');
            }

            // Email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('email').classList.add('error');
                valid = false;
            } else {
                document.getElementById('email').classList.remove('error');
            }

            // Password match validation
            if (password !== confirmPassword) {
                document.getElementById('confirm_password').classList.add('error');
                valid = false;
            } else {
                document.getElementById('confirm_password').classList.remove('error');
            }

            if (!valid) {
                event.preventDefault();
                return false;
            }
        }
    </script>
</head>
<body>
    <!-- Sticky Header -->
    <header class="sticky-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Institution Name</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
                <a class="btn btn-outline-primary ml-2" href="index.php">Back to Home</a>
            </div>
        </nav>
    </header>

    <div class="container form-container">
        <h2 class="text-center">Student Registration</h2>
        <form action="register.php" method="post" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
                <div class="form-text">Surname should not contain special characters except for periods.</div>
            </div>
            <div class="mb-3">
                <label for="other_names" class="form-label">Other Names</label>
                <input type="text" class="form-control" id="other_names" name="other_names" required>
                <div class="form-text">Other names should not contain special characters except for periods.</div>
            </div>
            <div class="mb-3">
                <label for="sex" class="form-label">Sex</label>
                <select class="form-select" id="sex" name="sex" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                <div class="form-text">Phone number should start with 0 and be 10 digits or 9 digits without 0.</div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="form-text">Please enter a valid email address.</div>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">District of Residence</label>
                <select class="form-select" id="district" name="district" required>
                    <?php
                    include 'db.php'; // Include database connection file
                    $query = "SELECT id, Name FROM district";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nationality</label>
                <select class="form-select" id="nationality" name="nationality" required>
                    <?php
                    $query = "SELECT id, country_name FROM countries";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['country_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
