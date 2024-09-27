<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/student.php");

if (isset($_FILES['photo']) && isset($_FILES['id_proof']) && isset($_POST['create_student'])) {

    echo "<pre>";
    print_r($_FILES);
    exit;

    // File validation
    if (!in_array($_FILES['photo']['type'], ['image/png', 'image/jpeg', 'image/jpg'])) {
        echo "WRONG TYPE UPLOADED for Photo";
        exit;
    }

    if (!in_array($_FILES['id_proof']['type'], ['image/png', 'image/jpeg', 'image/jpg'])) {
        echo "WRONG TYPE UPLOADED for ID Proof";
        exit;
    }

    // Define size limits (in bytes)
    $minSize = 0;  // Minimum size limit (50 KB)
    $maxSize = 102500; // Maximum size limit (100 KB)

    // Validate the size of the photo
    if ($_FILES['photo']['size'] < $minSize || $_FILES['photo']['size'] > $maxSize) {
        echo "Photo size must be between 51 KB and 100 KB.";
        exit;
    }

    // Validate the size of the ID proof
    if ($_FILES['id_proof']['size'] < $minSize || $_FILES['id_proof']['size'] > $maxSize) {
        echo "ID proof size must be between 51 KB and 100 KB.";
        exit;
    }


    // Get file content and types
    $imgData = file_get_contents($_FILES['photo']['tmp_name']);
    $imgData2 = file_get_contents($_FILES['id_proof']['tmp_name']);
    $photoType = $_FILES['photo']['type'];
    $idProofType = $_FILES['id_proof']['type'];

    // Prepare SQL statement
    $sql = "INSERT INTO documents (photo, id_proof, photo_type, id_proof_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Statement preparation failed: " . $conn->error;
        exit;
    }

    // Bind the parameters (s for strings, b for blob)
    $stmt->bind_param("bbss", $imgData, $imgData2, $photoType, $idProofType);

    // Send binary data in chunks to avoid exceeding limits
    $stmt->send_long_data(0, $imgData);  // Send photo
    $stmt->send_long_data(1, $imgData2); // Send ID proof

    // Execute the query
    if ($stmt->execute()) {
        echo "Images uploaded successfully.";
    } else {
        echo "Failed to upload images: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
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
                <h4 class="fw-bold text-uppercase">Add New Student</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Basic Details
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL ?>students/temp.php" enctype="multipart/form-data">
                            <div class="card-header mt-lg-2">
                                Required Documents
                            </div>
                            <label for="">Name</label>
                            <input type="text" name="name">

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Id Proof</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="id_proof" class="form-control gap-1 m-2" required />
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Admission Receipt</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="admission_receipt" class="form-control gap-1 m-2" required />
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="form-label">Photograph</label>
                                        <div class="d-flex align-items-center">
                                            <input type="file" name="photo" class="form-control gap-1 m-2" required />
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="popover" data-bs-title="Important Details" data-bs-content="Only .png, .jpeg, and .jpg formats are allowed"><i class="fa-solid fa-exclamation"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-3">

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Submit
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Do You want to submit?</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h2 class="text-secondary fw-bold">
                                                            Please check all details, then Submit
                                                        </h2>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button name="create_student" type="submit" class="btn btn-outline-success">
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="reset" class="btn btn-secondary">
                                            Cancel
                                        </button>
                                    </div>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASE_URL ?>rooms/add_room.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Hostel Number</label>
                        <input type="text" class="form-control" placeholder="Enter Hostel Number" id="exampleInputEmail1" aria-describedby="emailHelp" name="hostel_number">

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Total Rooms</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="total_rooms" placeholder="Enter Total Rooms">
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