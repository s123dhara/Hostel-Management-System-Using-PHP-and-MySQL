<?php include_once("../config/config.php");
include_once("../config/database.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
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
                                    <?php if (!empty($rooms)) { // Check if the rooms array is not empty
                                        $i = 1; // Initialize counter
                                        foreach ($rooms as $row) { // Loop through each room in the array 
                                    ?>
                                            <tr>
                                                <th><?php echo $i++; ?></th> <!-- Display the row number -->
                                                <td><?php echo $row['room_number'] ?></td> <!-- Room number -->
                                                <td>
                                                    <span class="badge text-bg-secondary"><?php echo $row['current_occupancy'] ?></span>
                                                    <span class="badge text-bg-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal">Click here</span>
                                                </td>
                                                <td><?php echo $row['floor_number'] ?></td>
                                                <td><?php echo $row['hostel_number'] ?></td>
                                                <td><?php echo htmlspecialchars($row['room_type']); ?></td> <!-- Room type -->

                                                <td>
                                                    <?php

                                                    $status = getStatus($conn, $row);

                                                    if ($status == 'Available') { ?>
                                                        <span class="badge text-bg-success"><?php echo $status ?></span> <!-- Room status -->
                                                    <?php } else if ($status == 'Occupied') { ?>
                                                        <span class="badge text-bg-danger"><?php echo $status ?></span> <!-- Room status -->
                                                    <?php } else {  ?>
                                                        <span class="badge text-bg-warning"><?php echo $status ?></span> <!-- Room status -->
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo BASE_URL ?>rooms/edit-room.php?id=<?php echo $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <button class="btn btn-danger btn-sm" data-bs-target="#staticBackdrop" data-bs-toggle="modal">Delete</button>
                                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Are You Want to Remove?</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h2 class="text-danger fw-bold">Changes are permanent cannot be updated</h2>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                                    <a href="<?php echo BASE_URL ?>rooms?action=delete&id=<?php echo $row['id'] ?>" class="btn btn-outline-danger btn-sm">Confirm</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No rooms available.</td> <!-- Message if no rooms are found -->
                                        </tr>
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