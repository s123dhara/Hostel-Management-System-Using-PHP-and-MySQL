<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/student.php");

?>

<?php


$students = getAllStudents($conn, 'Pending');
if (!isset($students->num_rows)) {
    $_SESSION['error'] = "Error: " . $conn->error;
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
                <h4 class="fw-bold text-uppercase">Pending Requests
                </h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Waiting Students
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-responsive table-striped" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>

                                        <th scope="col">Stream</th>
                                        <th scope="col">Course</th>
                                        <th scope="col">Semester</th>

                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($students->num_rows > 0) {
                                        $i = 1;
                                        $pendings_students = false;
                                        while ($row = $students->fetch_assoc()) { ?>
                                            <?php if ($row['student_status'] == 'Pending') {
                                                $pendings_students = true;
                                            ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i++ ?></th>
                                                    <td><?php echo $row['first_name'] . $row['last_name'] ?></td>
                                                    <td><?php echo $row['stream'] ?></td>
                                                    <td><?php echo $row['course'] ?></td>
                                                    <td><?php echo $row['semester'] ?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($row['apply_date'])) ?></td>
                                                    <td><span class="badge text-bg-warning"><?php echo $row['student_status'] ?></span></td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL ?>students/view-request.php?id=<?php echo $row['id'] ?>" class="btn btn-info btn-sm">View</a>

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