<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/student.php");


$isAdmin = ($_SESSION['user']['isAdmin']);
$user = $_SESSION['user'];

if (isset($_FILES['photo']) && isset($_FILES['id_proof']) && isset($_FILES['admission_receipt'])  && isset($_POST['create_student'])) {
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);
    exit;
    $res = create_Student_by_admin($conn, $_POST, $_FILES);

    if (isset($res['success']) && $res['success'] == true) {
        $_SESSION['success'] = "Student recocrd has been created successfully";
        header("Location: " . BASE_URL . "students");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
        header("Location: " . BASE_URL . "students");
        exit;
    }
}

if (isset($_FILES['photo']) && isset($_FILES['id_proof']) && isset($_FILES['admission_receipt'])  && isset($_POST['update_student'])) {
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // exit;
    $res = update_Student_by_admin($conn, $_POST, $_FILES, $user['student_id'], $user['email']);

    if (isset($res['success']) && $res['success'] == true) {
        $_SESSION['success'] = "Student recocrd has been Updated successfully";
        header("Location: " . BASE_URL . "students");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
        header("Location: " . BASE_URL . "students");
        exit;
    }
}

?>

<?php
include_once(DIR_URL . "include/header.php");
include_once(DIR_URL . "include/topnavbar.php");
include_once(DIR_URL . "include/sidebar.php");
?>
<!--Main content start-->
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <!--Cards-->
        <div class="row">
            <div class="col-md-12">
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
                <h4 class="fw-bold text-uppercase">Add New Student</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Basic Details
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL ?>students/add-student.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>

                                        <input type="text" name="first_name" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" id="" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <?php if (!$isAdmin) {
                                            $disabled = "disabled"; ?>
                                            <input type="email" name="email" class="form-control" value="<?php echo $user['email'] ?>" <?php echo $disabled ?> />
                                        <?php } else { ?>
                                            <input type="email" name="email" class="form-control" />
                                        <?php } ?>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Guardian Name</label>
                                        <input type="text" name="guardian_name" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Guardian Phone Number</label>
                                        <input type="text" name="guardian_phone_number" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Relationship with Guardian</label>
                                        <input type="text" name="guardian_relationship" class="form-control" />
                                    </div>
                                </div>


                            </div>

                            <div class="card-header">
                                Address Details
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <div class="mb-2">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Town/Village</label>
                                        <input type="text" name="town_village" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" name="pincode" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                Admission Details
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Name of Institute</label>
                                        <input type="text" name="institute_name" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Current Semester</label>
                                        <input type="text" name="semester" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Stream</label>
                                        <input type="text" name="stream" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Course</label>
                                        <input type="text" name="course" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Admission Date</label>
                                        <input type="date" name="admission_date" class="form-control" />
                                    </div>
                                </div>

                            </div>

                            <div class="card-header mt-lg-2">
                                Required Documents
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Id Proof</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="id_proof" class="form-control gap-1 m-2" required />
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Admission Receipt</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="admission_receipt" class="form-control gap-1 m-2" required />
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Photograph</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="photo" class="form-control gap-1 m-2" required />
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">

                                        <!-- Button trigger modal -->
                                        <?php if($isAdmin) { ?>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confimationCheckModal">
                                            Submit
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="confimationCheckModal" tabindex="-1" aria-labelledby="confimationCheckModallLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="confimationCheckModallLabel">Do You want to submit?</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h2 class="text-secondary fw-bold">
                                                            Please check all details, then Submit
                                                        </h2>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button name="create_student" type="submit" class="btn btn-outline-success">
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else { ?>    
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confimationCheckModal">
                                            Submit
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="confimationCheckModal" tabindex="-1" aria-labelledby="confimationCheckModallLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="confimationCheckModallLabel">Do You want to submit?</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h2 class="text-secondary fw-bold">
                                                            Please check all details, then Submit
                                                        </h2>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button name="update_student" type="submit" class="btn btn-outline-success">
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <?php } ?>   
                                        <button type="reset" class="btn btn-secondary">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<!--Main content end-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASE_URL ?>rooms/add_room.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Hostel Number</label>
                        <input type="text" class="form-control" placeholder="Enter Hostel Number" id="exampleInputEmail1" aria-describedby="emailHelp" name="hostel_number">

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Total Rooms</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="total_rooms" placeholder="Enter Total Rooms">
                    </div>
                    <button type="submit" name="create_hostel" class="btn btn-primary">submit</button>
                </form>
                <!-- <button type="button" name="create_hostel" class="btn btn-primary">submit</button> -->

            </div>
        </div>
    </div>
</div>


<!-- Button trigger modal -->

<?php include_once(DIR_URL . "include/footer.php") ?>