<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/plan.php");
?>

<?php
$user = $_SESSION['user'];
var_dump($user['student_id']);

$bookings = findPlanIdAndDate($conn, $user['student_id']);
// echo "<pre>";
// var_dump($bookings);
// exit;

$plan_id = $bookings['plan_id'];
extract($bookings);
// echo "<pre>";
// var_dump($plan_id);
// print_r($plan_id);
// exit;
$plan = getPlanById($conn, $plan_id);
$status = getPlanStatus($conn, $plan_id);
// Check if the array is empty
if (empty($plan)) {
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
        <div class="row p-4">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <?php include_once(DIR_URL . "include/alerts.php"); ?>
                <h4 class="fw-bold text-uppercase">My Plan</h4>
            </div>

            <div class="col-md-12 d-flex justify-content-center align-items-center mt-3">
                <div class="card shadow-lg" style="width: 50%;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-primary">
                            <span class="fw-bolder">Plan Name:</span>
                            <span class="fw-bold"><?php echo $plan['title'] ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bolder">Duration:</span>
                            <span class="fw-bold"><?php echo $plan['duration'] . " Months"; ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bolder">Price:</span>
                            <span class="fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i><?php echo $plan['price'] ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bolder">Status:</span>
                            <?php if($status == 'Active') { ?>
                            <span class="fw-bold badge text-bg-success"><?php echo $status ?></span>
                            <?php } else if($status == 'Expired') { ?>
                            <span class="fw-bold badge text-bg-danger"><?php echo $status ?></span>
                            <?php } else { ?>
                                <span class="fw-bold badge text-bg-warning"><?php echo $status ?></span>
                            <?php } ?>

                        </li>
                        <li class="list-group-item">
                            <span class="fw-bolder">Start Date:</span>
                            <span class="fw-bold"><?php echo $check_in_date ?></span>
                        </li>
                        <li class="list-group-item">
                            <span class="fw-bolder">Expire Date:</span>
                            <span class="fw-bold"><?php echo $check_out_date ?></span>
                        </li>

                        <li class="list-group-item">
                            <a href="./choose-plan.php" class="btn btn-primary btn-sm float-end">Upgrade</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Main Content -->

<!-- Include footer -->
<?php include_once(DIR_URL . "include/footer.php") ?>