<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");

if (isset($_POST['create_hostel'])) {
    $res = createHostel($conn, $_POST);

    if (isset($res['success'])) {
        $_SESSION['success'] = "Hostel has been created successfully";
        header("Location: " . BASE_URL . "rooms/add_room.php");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
    }
}

if (isset($_POST['create_room'])) {
    $res = createRoom($conn, $_POST);

    if (isset($res['success'])) {
        $_SESSION['success'] = "Room has been created successfully";
        header("Location: " . BASE_URL . "rooms");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
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
                        <form method="post" action="<?php echo BASE_URL ?>rooms/add_room.php">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="room_number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" name="room_number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="room_number" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="floor_number" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="">Male</option>
                                            <option value="">Female</option>
                                            <option value="">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="room_number" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" name="room_number" class="form-control" />
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Guardian Name</label>
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Guardian Phone Number</label>
                                        <input type="text" name="room_number" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Relationship with Guardian</label>
                                        <input type="text" name="room_number" class="form-control" />
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
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">State</label>
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Town/Village</label>
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" name="floor_number" class="form-control" required />
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
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Current Semester</label>
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Stream</label>
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-2">
                                        <label class="form-label">Course</label>
                                        <input type="text" name="floor_number" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <label class="form-label">Admission Date</label>
                                        <input type="date" name="floor_number" class="form-control" required />
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
                                        <input type="file" name="floor_number" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Admission Receipt</label>
                                        <input type="file" name="floor_number" class="form-control" required />
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Photograph</label>
                                        <input type="file" name="floor_number" class="form-control" required />
                                    </div>
                                </div>

                            </div>


                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <button name="create_room" type="submit" class="btn btn-success">
                                            Create
                                        </button>

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