<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");
include_once(DIR_URL . "models/plan.php");

$Allstatus = getAllStatus($conn);

if (isset($_POST['create_plan'])) {
    $res = createPlan($conn, $_POST);

    // echo "<pre>"; print_r($_POST); exit;

    if (isset($res['success'])) {
        $_SESSION['success'] = "Plan has been added successfully";
        header("Location: " . BASE_URL . "plans/add-plan.php");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
    }
}

?>

<?php
include_once(DIR_URL . "include/header.php");
include_once(DIR_URL . "include/topnavbar.php");
include_once(DIR_URL . "include/sidebar.php");
?>
<!--Main content start-->
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <!--Cards-->
        <div class="row">
            <div class="col-md-12">
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
                <h4 class="fw-bold text-uppercase">Add New Plan</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Fill the Details
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL ?>plans/add-plan.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Duration (months)</label>
                                        <input type="text" name="duration" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="text" name="price" class="form-control" required />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button name="create_plan" type="submit" class="btn btn-success">
                                        Create
                                    </button>

                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--Main content end-->

<!-- Modal -->
<div class="modal fade" id="add_hostel_modal" tabindex="-1" aria-labelledby="add_hostel_modal_Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add_hostel_modal_Label">Create A New Hostel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASE_URL ?>rooms/add-room.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Hostel Number</label>
                        <input type="text" class="form-control" placeholder="Enter Hostel Number" name="hostel_number">

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Total Rooms</label>
                        <input type="text" class="form-control" name="total_rooms" placeholder="Enter Total Rooms">
                    </div>
                    <button type="submit" name="create_hostel" class="btn btn-primary">submit</button>
                </form>
                <!-- <button type="button" name="create_hostel" class="btn btn-primary">submit</button> -->

            </div>
        </div>
    </div>
</div>


<!-- Button trigger modal -->

<?php include_once(DIR_URL . "include/footer.php") ?>