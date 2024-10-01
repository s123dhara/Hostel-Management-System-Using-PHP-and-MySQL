<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/student.php");

//check VIEW-APPLICATION-PAGE for USER visibility
$user = $_SESSION['user'];
$email = $user['email'];
$user_by_email = getUserByEmail($conn, $email);
$user_staus = true;
if (isset($user_by_email) && $user_by_email['student_status'] == NULL) {
    $_SESSION['error'] = "NO FORM SUBMITTED";
    $user_staus = false;
}



if (isset($_GET) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM students WHERE id = $id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $img_id = $row['document_id'];
}


if (isset($_FILES['photo']) && isset($_FILES['id_proof']) && isset($_FILES['admission_receipt'])  && isset($_POST['update_student'])) {
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // exit;
    $res = update_Student_by_admin_or_user($conn, $_POST, $_FILES, $_GET['id']);

    if (isset($res['success']) && $res['success'] == true) {
        $_SESSION['success'] = "Student recocrd has been Updated successfully";
        if($user['isAdmin']){
            header("Location: " . BASE_URL . "students");
        }else{
            header("Location: " . BASE_URL . "dashbaord.php");
        }
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
        header("Location: " . BASE_URL . "students");
        exit;
    }
}


// From student side 
// $student_current_id = 3;
$student_current_id = $user['student_id'];
$result = getStudent_approve($conn, $student_current_id);
$isAdmin = ($_SESSION['user']['isAdmin']);


if (isset($result) && isset($isAdmin) && $result && !$isAdmin) {
    //means approved student
    // Cannot update details

    $_SESSION['error'] = "You Cann't Update the Form";
    // header("Location:" . BASE_URL . "students/view-request.php?id=". 5);
    // exit;
}


?>

<?php
include_once(DIR_URL . "include/header.php");
include_once(DIR_URL . "include/topnavbar.php");
include_once(DIR_URL . "include/sidebar.php");
?>
<!--Main content start-->
<main class="mt-3 pt-3">
    <div class="container-fluid">

    <?php if (!$user_staus) { ?>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <?php include_once(DIR_URL . "include/alerts.php"); ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>   


        <!--Cards-->
        <div class="row">
            <div class="col-md-12 p-4">
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
                <h4 class="fw-bold text-uppercase">Details of Student</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Basic Details
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL ?>students/view-request.php?id=<?php echo $_GET['id'] ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" value="<?php echo $row['middle_name'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name'] ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control" value="<?php echo $row['date_of_birth'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>

                                        <select name="gender" id="" class="form-control">
                                            <?php $selected = ''; ?>
                                            <?php if ($row['gender'] == 'Male') { ?>
                                                <option value="Male" selected>Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            <?php } else if ($row['gender'] == 'Female') { ?>
                                                <option value="Male">Male</option>
                                                <option value="Female" selected>Female</option>
                                                <option value="Others">Others</option>
                                            <?php } else if ($row['gender'] == 'Others') { ?>

                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others" selected>Others</option>
                                            <?php } else { ?>
                                                <option value="NA" selected>Please Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="others">Others</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" value="<?php echo $row['phone_number'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo $row['email'] ?>" />
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Guardian Name</label>
                                        <input type="text" name="guardian_name" class="form-control" value="<?php echo $row['guardian_name'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Guardian Phone Number</label>
                                        <input type="text" name="guardian_phone_number" class="form-control" value="<?php echo $row['guardian_phone_number'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Relationship with Guardian</label>
                                        <input type="text" name="guardian_relationship" class="form-control" value="<?php echo $row['guardian_relationship'] ?>" />
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
                                        <input type="text" name="address" class="form-control" value="<?php echo $row['address'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state" class="form-control" value="<?php echo $row['state'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Town/Village</label>
                                        <input type="text" name="town_village" class="form-control" value="<?php echo $row['town_village'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" name="pincode" class="form-control" value="<?php echo $row['pincode'] ?>" />
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
                                        <input type="text" name="institute_name" class="form-control" value="<?php echo $row['institute_name'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Current Semester</label>
                                        <input type="text" name="semester" class="form-control" value="<?php echo $row['semester'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Stream</label>
                                        <input type="text" name="stream" class="form-control" value="<?php echo $row['stream'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Course</label>
                                        <input type="text" name="course" class="form-control" value="<?php echo $row['course'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Admission Date</label>
                                        <input type="date" name="admission_date" class="form-control" value="<?php echo $row['admission_date'] ?>" />
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
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#id_proof_modal">
                                                View Document
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="id_proof" class="form-control gap-1 m-2" />
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="id_proof_modal" tabindex="-1" aria-labelledby="id_proof_modal_Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Adjust modal size if needed -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-4" id="id_proof_modal_Label">Id Proof</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0"> <!-- Remove padding to let the image take full space -->
                                                            <!-- <img src="displayPhoto.php?id=<?php echo $img_id ?>&&type=id_proof" class="img-fluid" alt=""> -->
                                                            <img src="displayPhoto.php?id=<?php echo $img_id ?>&&type=id_proof" class="img-fluid" alt="">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Admission Receipt</label>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#admission_receipt_modal">
                                                View Document
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="admission_receipt" class="form-control gap-1 m-2" />
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="admission_receipt_modal" tabindex="-1" aria-labelledby="admission_receipt_modal_Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Adjust modal size if needed -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-4" id="admission_receipt_modal_Label">Admission Receipt</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0"> <!-- Remove padding to let the image take full space -->
                                                            <img src="displayPhoto.php?id=<?php echo $img_id ?>&&type=admission_receipt" class="img-fluid" alt="">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Photograph</label>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#photograph_modal">
                                                View Document
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="photo" class="form-control gap-1 m-2" />
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="photograph_modal" tabindex="-1" aria-labelledby="photograph_modalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md"> <!-- Adjust modal size if needed -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-4" id="photograph_modalLabel">Photograph</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0"> <!-- Remove padding to let the image take full space -->
                                                            <img src="displayPhoto.php?id=<?php echo $img_id ?>&&type=photo" class="img-fluid" alt="">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>


                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">

                                        <?php
                                        ?>

                                        <?php if (isset($isAdmin) && $isAdmin && !$result) { ?>
                                            <!-- if admin then show it  -->
                                            <!-- Button trigger modal -->

                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Approve_Modal">
                                                Approve
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="Approve_Modal" tabindex="-1" aria-labelledby="Reject_Modal_Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 text-success fw-bold text-uppercase" id="Reject_Modal_Label">Are You sure?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h2 class="text-secondary fw-bold">
                                                                Do you want to Confirm? Then Click On <strong>Approve</strong>
                                                            </h2>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="<?php echo BASE_URL ?>students/change-Status.php?id=<?php echo $id ?>&type=approved" class="btn btn-outline-success">
                                                                Approve
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="reset" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Reject_Modal">
                                                Reject
                                            </button>



                                            <!-- Modal -->
                                            <div class="modal fade" id="Reject_Modal" tabindex="-1" aria-labelledby="Reject_Modal_Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 text-danger fw-bold text-uppercase" id="Reject_Modal_Label">Reason for Rejection</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body w-100">
                                                            <form action="">
                                                                <textarea class="form-control" style="resize: none;" id="rejectionReason" rows="5"></textarea>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <a href="<?php echo BASE_URL ?>students/change-Status.php?id=<?php echo $id ?>&type=reject" class="btn btn-outline-danger">
                                                                        Reject
                                                                    </a>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } else if ((isset($isAdmin)  && !$isAdmin && !$result)  || (isset($isAdmin) && $isAdmin && $result)) { ?>

                                            <!-- From Student side not approved or Admin Side can change it -->

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editStudent_Modal">
                                                Update
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editStudent_Modal" tabindex="-1" aria-labelledby="Reject_Modal_Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 text-success fw-bold text-uppercase" id="Reject_Modal_Label">Are You sure?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h2 class="text-secondary fw-bold">
                                                                Do you want to Confirm? Then Click On <strong>Update Details</strong>
                                                            </h2>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="update_student" class="btn btn-outline-success">
                                                                Confirm
                                                                </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <a href="<?php echo BASE_URL ?>dashboard.php" class="btn btn-secondary">
                                                Cancel
                                            </a>

                                        <?php } ?>


                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>
    </div>
</main>
<!--Main content end-->



<?php include_once(DIR_URL . "include/footer.php") ?>