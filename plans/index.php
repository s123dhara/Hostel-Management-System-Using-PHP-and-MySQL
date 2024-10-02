<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/plan.php");
include_once(DIR_URL . "models/room.php");

?>

<?php
$plans = getPlans($conn);


// Check if the array is empty
if (empty($plans)) {
    $_SESSION['error'] = "Error: No rooms found or there was a problem fetching the room data.";
}


## Status update of Books
if (isset($_GET['action']) && $_GET['action'] == 'status') {
    $update = setStatus($conn, $_GET['id'], $_GET['status']);
    if ($update) {
        // if ($_GET['status'] == 1)
        //     $msg = "Plan has been successfully activated";
        // else $msg = "Plan has been successfully deactivated";

        // $_SESSION['success'] = $msg;
    } else {
        $_SESSION['error'] = "Something went wrong";
    }
    header("LOCATION: " . BASE_URL . "plans");
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
                <h4 class="fw-bold text-uppercase">Manage All Plans</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        All Plans
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-responsive table-striped" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Created_at</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($plans)) { // Check if the plans array is not empty
                                        $i = 1; // Initialize counter
                                        foreach ($plans as $row) { // Loop through each room in the array 

                                    ?>
                                            <tr>
                                                <th><?php echo $i++; ?></th> <!-- Display the row number -->
                                                <td><?php echo $row['title'] ?></td>
                                                <td><?php echo $row['duration'] . " Month" ?></td>
                                                <td><i class="fa-solid fa-indian-rupee-sign"></i> <?php echo $row['price'] ?></td>
                                                <td><?php echo date("d-m-Y H:i:s A", strtotime($row['created_at'])); ?></td>
                                                <?php if ($row['status'] == 1) { ?>
                                                    <td><span class="badge text-bg-success">Active</span></td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL ?>plans/edit-plan.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">Edit</a>
                                                        <a href="<?php echo BASE_URL ?>plans?action=status&id=<?php echo $row['id'] ?>&status=0" class="btn btn-outline-dark btn-sm">Deactivate</a>
                                                    </td>
                                                <?php } else if ($row['status'] == 0) { ?>
                                                    <td><span class="badge text-bg-warning">Inactive</span></td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL ?>plans/edit-plan.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">Edit</a>
                                                        <a href="<?php echo BASE_URL ?>plans?action=status&id=<?php echo $row['id'] ?>&status=1" class="btn btn-outline-success btn-sm">Activate</a>
                                                    </td>
                                                <?php } else {  ?>
                                                    <td><span class="badge text-bg-danger">Expired</span></td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL ?>plans/edit-plan.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">Edit</a>
                                                        <a href="<?php echo BASE_URL ?>plans?action=status&id=<?php echo $row['id'] ?>&status=0" class="btn btn-outline-dark btn-sm">Deactivate</a>
                                                        <a href="<?php echo BASE_URL ?>plans?action=status&id=<?php echo $row['id'] ?>&status=1" class="btn btn-outline-success btn-sm">Activate</a>
                                                    </td>
                                                <?php } ?>

                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No Plans available.</td> <!-- Message if no rooms are found -->
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
</main>
<!-- Main Content -->

<!-- Include footer -->
<?php include_once(DIR_URL . "include/footer.php") ?>