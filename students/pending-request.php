<?php include_once("../config/config.php");
include_once("../config/database.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/student.php");

?>

<?php
$rooms = getRooms($conn);

// Check if the array is empty
if (empty($rooms)) {
    $_SESSION['error'] = "Error: No rooms found or there was a problem fetching the room data.";
}


## Delete Rooms
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $del = deleteBook($conn, $_GET['id']);
    if ($del) {
        $_SESSION['success'] = "Room has been deleted successfully";
    } else {
        $_SESSION['error'] = "Something went wrong";
    }
    header("LOCATION: " . BASE_URL . "rooms");
    exit;
}

#update status & rooms
if (isset($_GET['action']) && $_GET['action'] == 'status') {
    $_SESSION['setStatus'] = 1;
    if (isset($_SESSION['setStatus'])) {
        if ($_GET['status'] == 1)
            $msg = "Room has been successfully activated";
        else $msg = "room has been successfully deactivated";

        $_SESSION['success'] = $msg;
    } else {
        $_SESSION['error'] = "Something went wrong";
    }
    header("LOCATION: " . BASE_URL . "rooms");
    exit;
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
                        All Books
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
                                    <tr>
                                        <th>1</th>
                                        <td>Supriyo dhara</td>

                                        <td>B.tech</td>
                                        <td>Computer Science</td>
                                        <td>2</td>
                                        <td>10/09/24</td>
                                        <td><span class="badge text-bg-warning">pending</span></td>
                                        <td>
                                        <a href="<?php echo BASE_URL ?>students/view-request.php" class="btn btn-info btn-sm">View</a>
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <td>sk paul</td>
                                     
                                        <td>B.tech</td>
                                        <td>Computer Science</td>
                                        <td>2</td>
                                        <td>10/09/24</td>
                                        <td><span class="badge text-bg-warning">pending</span></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm">View</a>
                                
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