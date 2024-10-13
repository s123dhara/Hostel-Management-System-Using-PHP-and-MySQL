<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/plan.php");
include_once(DIR_URL . "models/payment.php");
?>

<?php
$user = $_SESSION['user'];
$student_id = $user['student_id'];


if(isset($_POST) && isset($_POST['make_payment']) && isset($_GET['id'])) {
    $res = updatePayment($conn, $student_id, $_POST, $_GET['id']);
    if(isset($res['success']) ) {
        $_SESSION['success'] = $res['success'];
        header("Location:" . BASE_URL . "payments/payment-success.php");
        exit;
    }else {
        $_SESSION['error'] = $res['error'];
    }
}


if(isset($_GET) && isset($_GET['id'])) {
    $plan = getPlanById($conn, $_GET['id']);
    // Check if the array is empty
    if (empty($plan)) {
        $_SESSION['error'] = "Error: No Plans found or there was a problem fetching the room data.";
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
                <h4 class="fw-bold text-uppercase">Checkout | Buy Plan</h4>
            </div>

            <div class="col-md-12 d-flex justify-content-center align-items-center mt-3">
                <form class="row g-3 shadow p-4" action="<?php echo BASE_URL?>payments/payment.php?id=<?php echo $_GET['id'] ?>" method="post">
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
                        <input type="text" name="phone_number"  class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Plan Name</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $plan['title'] ?>" <?php echo "disabled" ?> >
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Amount <i class="fa-solid fa-indian-rupee-sign"></i></label>
                        <input type="text" name="price" class="form-control" value="<?php echo  $plan['price'] ?>" <?php echo "disabled" ?> >
                    </div>

                    <div class="col-md-4">
                        <label  class="form-label">Duration (Months)</label>
                        <input type="text" name="duration" class="form-control" value="<?php echo $plan['duration'] ?>" <?php echo "disabled" ?>>
                    </div>

                    
                    
                    <div class="col-12">
                        <button type="submit" name="make_payment" class="btn btn-primary">Checkout</button>
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