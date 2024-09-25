<?php include_once("./config/config.php") ?>
<?php
include_once("./include/header.php");
include_once("./include/topnavbar.php");
include_once("./include/sidebar.php");
?>

    <main class="mt-5 pt-3">
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
                            <button type="button" class="btn btn-warning position-relative">
                                View more
                                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </button>
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
    </main>


<!-- Include footer -->
<?php include_once("./include/footer.php") ?>