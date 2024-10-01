<?php
include_once("config/config.php");
include_once("config/database.php");
include_once(DIR_URL . "models/auth.php");

if(isset($_SESSION['is_user_login'])) {
    header("LOCATION: " . BASE_URL . 'dashboard.php');
    exit;
}


// Login Functionality (pizza123)
if (isset($_POST['submit'])) {
    $res = login($conn, $_POST);
    if ($res['status'] == true) {
        $_SESSION['is_user_login'] = true;
        $_SESSION['user'] = $res['user'];
        header("LOCATION: " . BASE_URL . 'dashboard.php');
        exit;
    } else {
        $_SESSION['error'] = "Invalid login information";
        header("LOCATION: " . BASE_URL . "login.php");
        exit;
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Novelty Hostel</title>

    <!-- Style css Custom -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/682c28b575.js" crossorigin="anonymous"></script>
</head>

<body style="background-color: #212529">
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="row">
            <div class="col-md-12 login-form">
                <div class="card mb-3" style="max-width: 900px">
                    <div class="row g-0">
                        <div class="col-md-5 d-flex align-items-center justify-content-center">
                            <img src="./assets/images/login-photo.png" class="img-fluid rounded-start mt-5" style="width: 100%; height: auto;" />
                        </div>


                        <div class="col-md-7">
                            <div class="card-body">
                                <h1 class="card-title text-uppercase fw-bold">
                                    Novelty Hostel
                                </h1>
                                <p class="text-secondary">Enter email and password to login</p>
                                <?php include_once(DIR_URL . "include/alerts.php") ?>

                                <form method="post" action="<?php echo BASE_URL ?>login.php">
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" class="form-control" name="email" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" />
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                                </form>

                                <hr />
                                <div class="mb-3 d-flex gap-3">
                                    <a href="./forgot-password.html" class="card-text text-dark">Forgot Password</a>
                                    <a href="<?php echo BASE_URL ?>signup.php" class="card-text text-dark">New User?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap CDN JS -->
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>