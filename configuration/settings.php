<?php
include 'connection/db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $institution_name = mysqli_real_escape_string($conn, $_POST['institution_name']);
    $short_name = mysqli_real_escape_string($conn, $_POST['short_name']);
    $institution_phone = mysqli_real_escape_string($conn, $_POST['institution_phone']);
    $director_phone = mysqli_real_escape_string($conn, $_POST['director_phone']);
    $principal_phone = mysqli_real_escape_string($conn, $_POST['principal_phone']);
    $accountant_phone = mysqli_real_escape_string($conn, $_POST['accountant_phone']);
    $support_phone = mysqli_real_escape_string($conn, $_POST['support_phone']);
    $institution_email = mysqli_real_escape_string($conn, $_POST['institution_email']);
    $director_email = mysqli_real_escape_string($conn, $_POST['director_email']);
    $support_email = mysqli_real_escape_string($conn, $_POST['support_email']);
    $address_line1 = mysqli_real_escape_string($conn, $_POST['address_line1']);
    $address_line2 = mysqli_real_escape_string($conn, $_POST['address_line2']);
    $address_line3 = mysqli_real_escape_string($conn, $_POST['address_line3']);

    // Handle logo upload
    $target_dir = "uploads/";
    $logo = basename($_FILES["logo"]["name"]);
    $target_file = $target_dir . $logo;
    move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);

    // Save settings to the database
    $sql = "INSERT INTO settings (institution_name, short_name, logo, institution_phone, director_phone, principal_phone, accountant_phone, support_phone, institution_email, director_email, support_email, address_line1, address_line2, address_line3)
            VALUES ('$institution_name', '$short_name', '$logo', '$institution_phone', '$director_phone', '$principal_phone', '$accountant_phone', '$support_phone', '$institution_email', '$director_email', '$support_email', '$address_line1', '$address_line2', '$address_line3')";

    if (mysqli_query($conn, $sql)) {
        echo "Settings saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institution Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Institution Settings</h2>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <!-- Institution Information Combo -->
        <div class="accordion mb-3" id="institutionAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Institution Information
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#institutionAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label for="institution_name" class="form-label">Institution Name</label>
                            <input type="text" class="form-control" id="institution_name" name="institution_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="short_name" class="form-label">Short Name</label>
                            <input type="text" class="form-control" id="short_name" name="short_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Institution Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information Combo -->
        <div class="accordion mb-3" id="contactAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Contact Information
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#contactAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label for="institution_phone" class="form-label">Institution Phone</label>
                            <input type="text" class="form-control" id="institution_phone" name="institution_phone" required pattern="^0\d{9}$" title="Phone number must start with 0 and contain exactly 10 digits.">
                        </div>
                        <div class="mb-3">
                            <label for="director_phone" class="form-label">Director's Phone</label>
                            <input type="text" class="form-control" id="director_phone" name="director_phone" required pattern="^0\d{9}$" title="Phone number must start with 0 and contain exactly 10 digits.">
                        </div>
                        <div class="mb-3">
                            <label for="principal_phone" class="form-label">Principal's Phone</label>
                            <input type="text" class="form-control" id="principal_phone" name="principal_phone" required pattern="^0\d{9}$" title="Phone number must start with 0 and contain exactly 10 digits.">
                        </div>
                        <div class="mb-3">
                            <label for="accountant_phone" class="form-label">Accountant's Phone</label>
                            <input type="text" class="form-control" id="accountant_phone" name="accountant_phone" required pattern="^0\d{9}$" title="Phone number must start with 0 and contain exactly 10 digits.">
                        </div>
                        <div class="mb-3">
                            <label for="support_phone" class="form-label">Support Team Phone</label>
                            <input type="text" class="form-control" id="support_phone" name="support_phone" required pattern="^0\d{9}$" title="Phone number must start with 0 and contain exactly 10 digits.">
                        </div>
                        <div class="mb-3">
                            <label for="institution_email" class="form-label">Institution Email</label>
                            <input type="email" class="form-control" id="institution_email" name="institution_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="director_email" class="form-label">Director's Email</label>
                            <input type="email" class="form-control" id="director_email" name="director_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="support_email" class="form-label">Support Team Email</label>
                            <input type="email" class="form-control" id="support_email" name="support_email" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Physical Address Combo -->
        <div class="accordion mb-3" id="addressAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Physical Address
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#addressAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label for="address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" required>
                        </div>
                        <div class="mb-3">
                            <label for="address_line2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2" required>
                        </div>
                        <div class="mb-3">
                            <label for="address_line3" class="form-label">Address Line 3 (Country)</label>
                            <input type="text" class="form-control" id="address_line3" name="address_line3" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Input Validation Script -->
<script>
function validateForm() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"]');
    for (let input of inputs) {
        if (!sanitizeInput(input.value)) {
            alert("Invalid characters detected. Please remove any code-like input.");
            return false;
        }
    }
    return true;
}

function sanitizeInput(input) {
    const regex = /<|>|script|alert|onload|onerror|javascript|src=/gi;  // basic XSS prevention
    return !regex.test(input);
}
</script>
</body>
</html>
