<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");
include_once(DIR_URL . "models/plan.php");
?>

<?php
if (isset($_GET) && isset($_GET['id'])) {
    $isPlanActive = false;
    $plans = findPlanIdAndDate($conn, $_GET['id']);
    if (isset($plans) && $plans == NULL) {
        $_SESSION['error'] = "No Active Plans";
    } else if($plans != NULL) {

        $isPlanActive = true;
        $plan = getPlanById($conn, $plans['plan_id']);
        if (empty($plan)) {
            $_SESSION['error'] = "Error: No Plans found or there was a problem fetching the room data.";
        }
    }
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
        <div class="row p-4">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
                <h4 class="fw-bold text-uppercase">Upgrade Plan | Admin</h4>
            </div>

            <div class="col-md-12 d-flex justify-content-center align-items-center mt-3">
                <form class="row g-3 shadow p-4">
                    <div class="col-md-8">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Plan Name</label>
                        <?php if ($isPlanActive) { ?>
                            <input type="text" name="title" class="form-control" value="<?php echo $plan['title'] ?>">
                        <?php } else { ?>
                            <input type="text" name="title" class="form-control">
                        <?php } ?>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Amount <i class="fa-solid fa-indian-rupee-sign"></i></label>
                        <?php if ($isPlanActive) { ?>
                        <input type="text" name="price" class="form-control" value="<?php echo  $plan['price'] ?>">
                        <?php } else { ?>
                            <input type="text" name="price" class="form-control">
                        <?php } ?>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Duration (Months)</label>
                        <?php if ($isPlanActive) { ?>
                        <input type="text" name="duration" class="form-control" value="<?php echo $plan['duration'] ?>" >
                        <?php } else { ?>
                            <input type="text" name="duration" class="form-control">
                        <?php } ?>
                    </div>



                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Upgrade</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- Main Content -->

<!-- Include footer -->
<?php include_once(DIR_URL . "include/footer.php") ?>