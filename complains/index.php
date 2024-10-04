<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");
include_once(DIR_URL . "models/complain.php");
include_once(DIR_URL . "models/student.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/hostel.php");
?>

<?php

if (isset($_GET) && isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'status') {
    extract($_GET);
    $SQL = "UPDATE complains SET status = 1 WHERE id = $id";
    $res = $conn->query($SQL);

    if ($res) {
        $_SESSION['success'] = "Issue has been successfully resolved";
    } else {
        $_SESSION['error'] = "Error In Resolving Complains";
    }
}

$user = $_SESSION['user'];
$complains = getAllComplains($conn);
if (!isset($complains)) {
    $_SESSION['error'] = "No Complains Found";
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
                <h4 class="fw-bold text-uppercase">View Complains</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        All Complains
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
                                        <th scope="col">Subject</th>
                                        <th scope="col">Issue</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Registerd At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($complains->num_rows > 0) {
                                        $i = 1;
                                        while ($row = $complains->fetch_assoc()) { ?>
                                            <?php if ($row['status'] == 0) { ?>

                                                <?php

                                                $student_id = $row['student_id'];
                                                $query = "SELECT * FROM students WHERE id = $student_id";
                                                $res = $conn->query($query);
                                                $student = $res->fetch_assoc();
                                                $room = getRoomById($conn, $student['room_id']);
                                                $room = $room->fetch_assoc();
                                                $hostel = getHostelById($conn, $room['hostel_id']);
                                                $hostel = $hostel->fetch_assoc();
                                                ?>

                                                <tr>
                                                    <th scope="row"><?php echo $i++ ?></th>
                                                    <td><?php echo $row['name'] ?></td>
                                                    <td><?php echo $room['room_number'] ?></td>
                                                    <td><?php echo $hostel['hostel_number'] ?></td>
                                                    <td><?php echo $row['subject'] ?></td>
                                                    <td>

                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#complain_issue">
                                                            Click Here
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="complain_issue" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="complain_issueLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="complain_issueLabel">Issue</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php echo $row['issue'] ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#complain_issue_photo">
                                                        Photo
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="complain_issue_photo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="complain_issueLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="complain_issueLabel">Issue</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="<?php echo BASE_URL ?>complains/displayPhoto.php?id=<?php echo $row['id'] ?>" class="img-fluid" alt="Not Found">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    </td>

                                                    <td><?php echo date("m-d-Y H:i:s A", strtotime($row['created_at'])) ?></td>

                                                    <?php if ($row['status'] == 0) { ?>
                                                        <td><span class="badge text-bg-warning">Registerd</span></td>
                                                    <?php } else if ($row['status'] == 1) { ?>
                                                        <td><span class="badge text-bg-success">Resolved</span></td>
                                                    <?php } ?>

                                                    <td>
                                                        <a href="<?php echo BASE_URL ?>complains?id=<?php echo $row['id'] ?>&action=status" class="btn btn-outline-success">Resolve</a>
                                                    </td>
                                                </tr>
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
</main>
<!-- Main Content -->

<!-- Include footer -->
<?php include_once(DIR_URL . "include/footer.php") ?>