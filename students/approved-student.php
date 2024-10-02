<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/student.php");
include_once(DIR_URL . "models/plan.php");
?>

<?php


$students = getAllStudents($conn);
if (!isset($students->num_rows)) {
    $_SESSION['error'] = "Error: " . $conn->error;
}


$AllPlans= getAllPlans($conn);
if (!isset($students->num_rows)) {
    $_SESSION['error'] = "Error: " . $conn->error;
}

$type = 'Approved';
$pending_students = getAllStudents($conn, $type);
$pending_students_result = false;

// Check if there are pending students
if ($pending_students && $pending_students->num_rows > 0) {
    $pending_students_result = true; // Set to true if any pending students exist
}

if (isset($_POST) && isset($_POST['assign_student'])) {
    // echo "<pre>";
    // print_r($_POST);
    // exit;
    // Call the function to create a booking
    $res = createBooking_by_admin($conn, $_POST, $_GET);
    
    // Check the result and handle success/error
    if (isset($res['success'])) {
        // Redirect or show a success message
        $_SESSION['success'] = $res['success'];
        header("LOCATION: " . BASE_URL . "students"); // Redirect to bookings page
        exit;
    } elseif (isset($res['error'])) {
        // Show the error message
        $_SESSION['error'] = $res['error'];
    }
}





?>


<!-- Repeated Content in HTML -->
<?php
include_once(DIR_URL . "include/header.php");
include_once(DIR_URL . "include/topnavbar.php");
include_once(DIR_URL . "include/sidebar.php");
?>
<!-- Repeated Content in HTML -->


<!-- Main Content -->
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <!--Cards-->
        <div class="row dashboard-counts">
            <div class="col-md-12">
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
                <h4 class="fw-bold text-uppercase">Approved Students
                    <a href="<?php echo BASE_URL ?>students/pending-request.php" target="_blank" class="btn btn-warning position-relative float-end mb-2">
                        Pending Request
                        <?php
                        if ($pending_students_result) { ?>
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        <?php } ?>
                    </a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        All Books
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-responsive table-striped" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Room Number</th>
                                        <th scope="col">Hostel Number</th>
                                        <th scope="col">Stream</th>
                                        <th scope="col">Course</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($students->num_rows > 0) {
                                        $i = 1;
                                        while ($row = $students->fetch_assoc()) { ?>

                                            <?php if($row['payment_status'] == 0) { ?> 

                                            <?php $room = getRoomById($conn, $row['room_id']);
                                            $room = $room->fetch_assoc();
                                            $room_number = $room['room_number'];

                                            $hostel = getHostelById($conn, $room['hostel_id']);
                                            $hostel = $hostel->fetch_assoc();
                                            $hostel_number = $hostel['hostel_number'];
                                            ?>

                                            <?php if ($row['student_status'] == 'Approved') { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i++ ?></th>
                                                    <td><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></td>
                                                    <td><?php echo $room_number ?></td>
                                                    <td><?php echo $hostel_number ?></td>
                                                    <td><?php echo $row['stream'] ?></td>
                                                    <td><?php echo $row['course'] ?></td>
                                                    <td><?php echo $row['semester'] ?></td>
                                                    <td>10/09/24</td>
                                                    <td><span class="badge text-bg-warning">Not Paid</span></td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL ?>students/view-request.php?id=<?php echo $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>

                                                        <button class="btn btn btn-outline-dark btn-sm" data-bs-target="#assignPayment" data-bs-toggle="modal">Assign</button>
                                                        <div class="modal fade" id="assignPayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assignPaymentLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="assignPaymentLabel">Choose A Plan</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="<?php echo BASE_URL ?>students/approved-student.php?id=<?php echo $row['id']?>&room_id=<?php echo $row['room_id'] ?>">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Plan</label>
                                                                                <select name="plan_title_id" class="form-select" required>
                                                                                    <option value="">Select a Plan</option> <!-- Default option -->

                                                                                    <?php while ($row = $AllPlans->fetch_assoc()) { ?>
                                                                                        <!-- // Assuming 'title' is the column name in your database for the plan title -->
                                                                                        <!-- $title = htmlspecialchars($row['title']); // Sanitize output -->
                                                                                        
                                                                                        <?php if($row['status'] == 1) { ?> 
                                                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>
                                                                                        <?php } ?> 
                                                                                    <?php } ?>
                                                                                </select>

                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label  for="exampleCheck1">Duration</label>
                                                                                <select name="duration" id="" class="form-control">
                                                                                    <option value="1">1 Month</option>
                                                                                    <option value="3">3 Months</option>
                                                                                    <option value="6">6 Months</option>
                                                                                    <option value="9">9 Months</option>
                                                                                    <option value="12">12 Months</option>
                                                                                </select>

                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-check-label" for="exampleCheck1">Start Date</label>
                                                                                <input type="date" name="check_in_date" class="form-control">
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" name="assign_student" class="btn btn-outline-dark btn-sm">Assign</a>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        <?php } ?>
                                        <?php } ?>                                                                                               
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Room: A101 And Hostel: A1</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Check in</th>
                                <th scope="col">Check out</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>10/09/24</td>
                                <td>10/10/24</td>
                                <td><span class="badge text-bg-warning">Running</span></td>
                                <td><a href="" class="btn btn-outline-primary btn-sm">Edit</a></td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>10/09/24</td>
                                <td>10/10/24</td>
                                <td><span class="badge text-bg-warning">Running</span></td>
                                <td><a href="" class="btn btn-outline-primary btn-sm">Edit</a></td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>10/09/24</td>
                                <td>10/10/24</td>
                                <td><span class="badge text-bg-warning">Running</span></td>
                                <td><a href="" class="btn btn-outline-primary btn-sm">Edit</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</main>
<!-- Main Content -->

<!-- Include footer -->
<?php include_once(DIR_URL . "include/footer.php") ?>