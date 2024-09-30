<?php include_once("config/config.php");
include_once("config/database.php");

?>
<?php
include_once("./include/header.php");
include_once("./include/topnavbar.php");
include_once("./include/sidebar.php");
include_once(DIR_URL . "models/student.php");


$type = 'Pending';
$pending_students = getAllStudents($conn, $type);
$pending_students_result = false;

// Check if there are pending students
if ($pending_students && $pending_students->num_rows > 0) {
    $pending_students_result = true; // Set to true if any pending students exist
}


?>

<main class="mt-5 pt-3">

    <?php if (false) { ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 my-3">
                    <h4 class="fw-bold text-uppercase">Dashboard</h4>
                    <p>Statistics of the system!</p>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted">
                                Total Alloted Rooms
                            </h6>
                            <p class="h1 fw-bold">21</p>
                            <a href="<?php echo BASE_URL ?>books" class="card-link link-underline-light btn btn-primary">View more
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted">
                                Total Students
                            </h6>
                            <p class="h1 fw-bold">10</p>
                            <a href="<?php echo BASE_URL ?>students" class="card-link link-underline-light btn btn-primary">View more</a>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted">
                                Recent Pending Requests
                            </h6>
                            <p class="h1 fw-bold">10</p>

                            <a href="<?php echo BASE_URL ?>students/pending-request.php" class="btn btn-warning position-relative">
                                Pending Request
                                <?php
                                if ($pending_students_result) { ?>
                                    <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                <?php } ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted">
                                Recent Complaints
                            </h6>
                            <p class="h1 fw-bold">10</p>
                            <a type="button" class="btn btn-primary position-relative">
                                View more
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!--Tabs-->
            <div class="row mt-5">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-uppercase active" id="new-students" data-bs-toggle="tab" data-bs-target="#new-students-pane" type="button" role="tab" aria-controls="new-students-pane" aria-selected="true">
                                New Students
                            </button>
                        </li>


                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="new-students-pane" role="tabpanel" aria-labelledby="new-students" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-responsive table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone No</th>
                                            <th scope="col">Registered On</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>supriyo</td>
                                            <td>supriyo</td>
                                            <td>supriyo</td>
                                            <td><span class="badge text-bg-warning">Active</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="recent-loans-pane" role="tabpanel" aria-labelledby="recent-loans" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-responsive table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Book Name</th>
                                            <th scope="col">Student Name</th>
                                            <th scope="col">Loan Date</th>
                                            <th scope="col">Due Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>supriyo</td>
                                            <td>supriyo</td>
                                            <td>supriyo</td>
                                            <td>supriyo</td>
                                            <td><span class="badge text-bg-warning">Active</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 my-3">
                    <h4 class="fw-bold text-uppercase">Dashboard</h4>
                    <p>Explore! Statistics of Profile</p>
                </div>

                <div class="col-md-3">
                    <div class="card mb-2">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted fw-bold">
                                Alloted Hostel
                            </h6>
                            <div class="mb-2">
                                <i class="fa-solid fa-hotel fa-2x"></i>
                            </div>

                            <h2 class=" btn btn-warning fw-bold">Not Alloted</h2>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-2">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted fw-bold">
                                Alloted Room
                            </h6>
                            <div class="mb-2">
                                <i class="fa-solid fa-house fa-2x"></i>
                            </div>
                            <h2 class=" btn btn-warning fw-bold">Not Alloted</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-2">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted fw-bold">
                                Payment Status
                            </h6>
                            <div class="mb-2">
                                <i class="fa-solid fa-indian-rupee-sign fa-2x"></i>
                            </div>
                            <h2 class=" btn btn-warning fw-bold">Not Paid</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-2">
                        <div class="card-body text-center">
                            <h6 class="card-title text-uppercase text-muted fw-bold">
                                Current Status
                            </h6>
                            <div class="mb-2">
                                <i class="fa-solid fa-clipboard-list fa-2x"></i>
                            </div>
                            <h2 class=" btn btn-warning fw-bold">Not Approved</h2>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row p-2 mt-5">
                <div class="col-md-12 my-2">
                    <h2 class="text-dark fw-bolder">Welcome! <span class="text-primary fw-bold">Supriyo Dhara</span></h2>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-plus fa-3x"></i>
                        </div>
                        <a href="#" class="btn btn-secondary fw-bolder">Apply For Hostel</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-book-open-reader fa-3x"></i>
                        </div>
                        <a href="#" class="btn btn-secondary fw-bolder">View Applicaton Form</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-hand-holding-dollar fa-3x"></i>
                        </div>
                        <a href="#" class="btn btn-secondary fw-bolder">Payment History</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-book fa-3x"></i>
                        </div>
                        <a href="#" class="btn btn-secondary fw-bolder">Raise Complaint</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-bars fa-3x"></i>
                        </div>
                        <a href="#" class="btn btn-secondary fw-bolder">My Plan</a>
                    </div>
                </div>
            </div>


        </div>


    <?php } ?>
</main>


<!-- Include footer -->
<?php include_once("./include/footer.php") ?>