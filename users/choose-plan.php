<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/plan.php");
?>

<?php
$plans = getPlans($conn);

// Check if the array is empty
if (empty($plans)) {
    $_SESSION['error'] = "Error: No Plans found or there was a problem fetching the room data.";
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
                <h4 class="fw-bold text-uppercase">Choose a Plan</h4>
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
                                        <th scope="col">Plan Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($plans)) { // Check if the rooms array is not empty
                                        $i = 1; // Initialize counter
                                        foreach ($plans as $row) { ?>
                                            <?php if ($row['status'] == 1) { ?>
                                                <tr>
                                                    <th><?php echo $i++; ?></th> <!-- Display the row number -->
                                                    <td><?php echo $row['title'] ?></td> <!-- Room number -->

                                                    <td><?php echo $row['price'] ?></td>
                                                    <td><?php echo $row['duration'] . " Months"; ?></td>
                                                    <td><span class="badge text-bg-success">Active</span> <!-- Room status --></td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL ?>payments/payment.php?id=<?php echo $row['id'] ?>" class="btn btn-outline-primary btn-sm">Pay</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

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