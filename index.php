<?php include_once("config/config.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novelty Hostel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/home.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-medium" href="<?php echo BASE_URL ?>">Novelty Hostel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL?>login.php">Student Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL?>login.php">Admin Login</a>
                    </li>
                   
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cover Content with Image -->
    <div class="container-fluid cover-container bg-light">
        
        <!-- Heading Section -->
        <h1 class="display-1 fw-bold">Welcome to My Novelty Hostel</h1>

        <!-- Text and Image Section (Side by Side) -->
        <div class="row justify-content-center align-items-center mt-4">
            <div class="col-lg-4 col-md-6 mb-4">
                <p class="lead hostel-description">
                    Welcome to our <Strong class="text-uppercase">hostel</Strong>, where comfort meets community. We offer cozy, modern rooms, 
                    high-speed Wi-Fi, and a <Strong class="text-uppercase">vibrant atmosphere</Strong>, for travelers and students alike. Our facilities 
                    include a spacious lounge, study areas, and a fully equipped kitchen to make your stay 
                    as convenient and <Strong class="text-uppercase">enjoyable</Strong> as possible.
                </p>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="<?php echo BASE_URL ?>assets/images/login-photo.png" alt="Cover Image" class="cover-image">
            </div>
        </div>
        <!-- Apply nwo Button -->
        <div class="row">
            <div class="col text-center">
                <a href="<?php echo BASE_URL ?>login.php" class="btn btn-primary btn-lg mt-3 mb-sm-3">Apply Now</a>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
