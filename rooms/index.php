<?php include_once("../config/config.php") ?>



<?php
include_once(DIR_URL . "include/header.php");
include_once(DIR_URL . "include/topnavbar.php");
include_once(DIR_URL . "include/sidebar.php");
?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <!--Cards-->
        <div class="row dashboard-counts">
            <div class="col-md-12">
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
                <h4 class="fw-bold text-uppercase">Manage Rooms</h4>
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
                                        <th scope="col">Room Number</th>
                                        <th scope="col">Current Occupancy</th>
                                        <th scope="col">Floor Number</th>
                                        <th scope="col">Hostel Name</th>
                                        <th scope="col">Room Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>1</th>
                                        <td>101</td>
                                        <td><span class="badge text-bg-secondary">1</span>
                                            <span class="badge text-bg-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal">Click here</span>
                                        </td>
                                        <td>2nd</td>
                                        <td>A1</td>
                                        <td>Double</td>
                                        <td><span class="badge text-bg-success">Available</span></td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
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


<!-- Include footer -->
<?php include_once(DIR_URL . "include/footer.php") ?>