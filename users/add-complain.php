<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/complain.php");
include_once(DIR_URL . "models/student.php");
?>

<?php
$user = $_SESSION['user'];
if (isset($_FILES['supported_docs'])  && isset($_POST['raise_complain'])) {

    $res = addNewComplain($conn, $_FILES, $_POST, $user['student_id']);
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
                <h4 class="fw-bold text-uppercase">Raise New Complaint</h4>
            </div>

            <div class="row d-flex justify-content-center align-items-center mt-3">
                <form method="post" action="<?php echo BASE_URL ?>users/add-complain.php" enctype="multipart/form-data" class="form-control shadow p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control">
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
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Write Down Complaint</label>
                                <textarea class="form-control" name="issue" rows="3" style="resize: none; height: 40vh"></textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Add Image</label>
                                <input type="file" name="supported_docs" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <button type="submit" name="raise_complain" class="btn btn-primary">Raise</button>
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