<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");
include_once(DIR_URL . "models/complain.php");
include_once(DIR_URL . "models/student.php");
include_once(DIR_URL . "models/notice.php");
?>

<?php
$user = $_SESSION['user'];
if (isset($_FILES['document'])  && isset($_POST['create_notice'])) {

    // echo "<pre>";
    // var_dump($_FILES);
    // var_dump($_POST);
    // exit;



    $res = addNewNotice($conn, $_FILES, $_POST);
    if (isset($res['success']) && $res['success'] == true) {
        $_SESSION['success'] = "Complaint has been registered successfully";
        header("Location: " . BASE_URL . "dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
        header("Location: " . BASE_URL . "dashboard.php");
        exit;
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
                <h4 class="fw-bold text-uppercase">Notice | Add New </h4>
            </div>

            <div class="row d-flex justify-content-center align-items-center mt-3">
                <form method="post" action="<?php echo BASE_URL ?>notices/add-notice.php" enctype="multipart/form-data" class="form-control shadow p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Add Document</label>
                                <input type="file" name="document" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <button type="submit" name="create_notice" class="btn btn-primary">Create</button>
                                <button type="reset"  class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</main>
<!-- Main Content -->

<!-- Include footer -->
<?php include_once(DIR_URL . "include/footer.php") ?>