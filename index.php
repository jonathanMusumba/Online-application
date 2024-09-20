<?php
$host = 'localhost';     
$user = 'root';         
$password = '';          
$dbname = 'online'; 

// Create a new mysqli connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch institution name from settings table
$institution_name_query = "SELECT institution_name FROM settings LIMIT 1";
$institution_name_result = $conn->query($institution_name_query);

if ($institution_name_result->num_rows > 0) {
    $row = $institution_name_result->fetch_assoc();
    $institution_name = $row['institution_name'];
} else {
    $institution_name = 'Institution Name'; // Default value if not found
}

// Fetch courses from the Courses table
$courses_query = "SELECT course_name, course_type, duration, tuition FROM Courses";
$courses_result = $conn->query($courses_query);
$courses = $courses_result->fetch_all(MYSQLI_ASSOC);

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($institution_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
          .hero {
            position: relative;
            height: 80vh; /* Increased height */
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            overflow: hidden;
        }
        .hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            z-index: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .hero img.active {
            opacity: 1;
        }
        .hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Overlay effect */
            z-index: 1;
            transition: background-color 0.5s ease-in-out;
        }
        .hero-content {
            z-index: 2;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease, transform 1s ease;
        }
        .hero.show .hero-content {
            opacity: 1;
            transform: translateY(0);
        }
        .hero h2 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .hero .btn {
            margin: 0.5rem;
        }
        .carousel-item {
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }
        .zoom-effect {
            transition: transform 0.5s ease-in-out;
        }
        .carousel-item.active .zoom-effect {
            transform: scale(1.1); /* Zoom effect on active slide */
        }
        .login-register {
            display: flex;
            gap: 1rem;
        }
        .sticky-header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        footer {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sticky Header -->
    <header class="sticky-header bg-dark text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <h1><?php echo htmlspecialchars($institution_name); ?></h1>
            <div class="login-register">
                <a href="login/login.php" class="btn btn-outline-light">Login</a>
                <a href="forms/Registration.php" class="btn btn-outline-light">Register</a>
            </div>
        </div>
    </header>

    <!-- Hero Section with Overlay -->
     <!-- Hero Section with Overlay -->
     <section class="hero text-center">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h2>Join Our Prestigious Institution</h2>
            <a href="learn_more.php" class="btn btn-primary">Learn More</a>
            <a href="login/login.php" class="btn btn-secondary">Apply Now</a>
        </div>
        <?php
        // Fetch hero images from the 'uploads/hero' directory
        $heroImages = glob('uploads/hero/*.jpg');
        $transitions = ['fade', 'slide', 'zoom', 'blur', 'morph', 'blinds', 'shred']; // Transition effects
        foreach ($heroImages as $index => $image) {
            $transition = $transitions[$index % count($transitions)];
            $activeClass = $index === 0 ? 'active' : '';
            echo "<img src=\"$image\" class=\"$activeClass $transition\" alt=\"Hero Image\" data-transition=\"$transition\">";
        }
        ?>
    </section>

    <!-- Courses Section with Carousel -->
    <section class="courses-section py-5">
    <div class="container">
        <h3 class="text-center mb-4">Available Courses</h3>
        <div id="coursesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php 
                $active = "active";
                $index = 0;
                foreach ($courses as $course) { 
                    if ($index % 3 === 0) { // Start a new set of 3 courses
                        echo $index > 0 ? '</div></div>' : ''; // Close previous carousel item
                        echo '<div class="carousel-item ' . $active . '"><div class="row justify-content-center">';
                    }
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card text-center mx-auto zoom-effect" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($course['course_name']); ?></h5>
                                <p class="card-text">
                                    Type: <?php echo htmlspecialchars($course['course_type']); ?><br>
                                    Duration: <?php echo htmlspecialchars($course['duration']); ?> years<br>
                                    Tuition: UGX <?php echo number_format($course['tuition'], 0); ?> <!-- Display tuition in UGX -->
                                </p>
                                <a href="apply_now.php" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                <?php 
                $index++;
                $active = ""; // Only the first item should be active
                } 
                echo '</div></div>'; // Close the last carousel item
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#coursesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#coursesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>


    <!-- Application Procedures -->
    <section class="application-procedures bg-light py-5">
    <div class="container">
        <h3 class="text-center mb-4">Application Procedures</h3>
        <p class="text-center mb-5">Follow these steps to apply to our institution:</p>

        <div class="row text-center">
            <!-- Step 1: Registration -->
            <div class="col-md-4 mb-4">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">Step 1: Registration</h5>
                        <p class="card-text">Create an account by filling out your details, including email, phone number, and password.</p>
                    </div>
                </div>
            </div>

            <!-- Step 2: Get the Code -->
            <div class="col-md-4 mb-4">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Step 2: Get the Code</h5>
                        <p class="card-text">Receive a unique verification code via email or SMS, which you'll need to verify your account.</p>
                    </div>
                </div>
            </div>

            <!-- Step 3: Login -->
            <div class="col-md-4 mb-4">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <h5 class="card-title">Step 3: Login</h5>
                        <p class="card-text">Log in to your account using your email and password to access the application form.</p>
                    </div>
                </div>
            </div>

            <!-- Step 4: Enter Verification Code (First Time) -->
            <div class="col-md-6 mb-4">
                <div class="card border-info h-100">
                    <div class="card-body">
                        <h5 class="card-title">Step 4: Enter Verification Code</h5>
                        <p class="card-text">If this is your first time logging in, enter the verification code to activate your account.</p>
                    </div>
                </div>
            </div>

            <!-- Step 5: Apply and Submit Application -->
            <div class="col-md-6 mb-4">
                <div class="card border-danger h-100">
                    <div class="card-body">
                        <h5 class="card-title">Step 5: Apply and Submit Application</h5>
                        <p class="card-text">Fill in the required information on the application form, upload any necessary documents, and submit your application for review.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3">
        <p><?php echo htmlspecialchars($institution_name); ?> &copy; 2024. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to update the hero background images
        function updateHeroImages() {
            const images = document.querySelectorAll('.hero img');
            let currentIndex = 0;
            
            setInterval(() => {
                images[currentIndex].classList.remove('active');
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.add('active');
            }, 5000); // Change image every 5 seconds
        }

        // Function to add a class to show hero content
        function showHeroContent() {
            const hero = document.querySelector('.hero');
            hero.classList.add('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateHeroImages();
            showHeroContent();
        });
    </script>
</body>
</html>
