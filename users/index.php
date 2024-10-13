<?php
include_once("../config/database.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/auth.php");
include_once(DIR_URL . "models/student.php");

$user = $_SESSION['user'];
$student_id = $user['student_id'];

$student = getStudentById($conn, $student_id)->fetch_assoc();


// // Change password functionality
// if (isset($_POST['password_submit'])) {
//     $res = changePassword($conn, $_POST);
//     if ($res['status'] == true) {
//         $_SESSION['success'] = $res['message'];
//         header("LOCATION: " . BASE_URL . 'my-profile.php');
//         exit;
//     } else {
//         $_SESSION['error'] = $res['message'];
//         header("LOCATION: " . BASE_URL . 'my-profile.php');
//         exit;
//     }
// }

// profile update functionality
if (isset($_FILES) && isset($_POST['profile_submit'])) {
    $res = updateProfile($conn, $_POST, $student_id, $_FILES);
    if (isset($res['success']) && $res['success'] != NULL) {
        $_SESSION['success'] = $res['success'];
    } else if(isset($res['error'])) {
        $_SESSION['error'] = $res['error'];
    }
    header("LOCATION: " . BASE_URL . "users");
    exit;
}




include_once(DIR_URL . "include/header.php");
include_once(DIR_URL . "include/topnavbar.php");
include_once(DIR_URL . "include/sidebar.php");
// 
?>

<!--Main Container Start-->
<main class="mt-5 pt-4">
    <div class="container-fluid">
        <!--Cards-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="fw-bold text-uppercase">My Profile</h4>
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
            </div>

            <!--Account info form-->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Account Information
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL ?>users/" enctype="multipart/form-data">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo $user['username'] ?>" />
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="mb-3 float-end">

                                            <?php if ($_SESSION['user']['profile_pic'] == NULL) { ?>
                                                <!-- Display default user icon if no profile picture is set -->
                                                <img src="<?php echo BASE_URL ?>assets/images/default-user.png" style="width: 100px; height:100px" alt="Default User" class="img-fluid rounded shadow">
                                            <?php } else { ?>
                                                <!-- Display user's profile picture if available -->
                                                <img src="<?php echo BASE_URL ?>users/displayPhoto.php?id=<?php echo $_SESSION['user']['id']; ?>&type=profile_pic" style="width: 100px; height:100px" alt="User Profile" class="img-fluid rounded shadow">
                                            <?php } ?>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo $user['email'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_no" value="<?php echo $student['phone_number'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3 position-relative">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" name="profile_pic" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" name="profile_submit" class="btn btn-success">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Change password form-->
            <div class="col-md-6">
                <div class="card" style="min-height:457px;">
                    <div class="card-header">
                        Change Password
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL ?>my-profile.php">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control" required name="current_pass" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" required name="new_pass" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" required name="conf_pass" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" name="password_submit" class="btn btn-success">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--Main Container End-->

<?php include_once(DIR_URL . "include/footer.php") ?>