<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");
include_once(DIR_URL . "models/student.php");
include_once(DIR_URL . "models/notice.php");

?>
<?php


$notices = getAllNotices($conn);
if (!$notices) {
    $_SESSION['error'] = "NO Notice Found";
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
                <h4 class="fw-bold text-uppercase">Manage Notice</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        All Notice
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-responsive table-striped" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Announced At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if ($notices->num_rows > 0) {
                                        $i = 1;
                                        while ($row = $notices->fetch_assoc()) {
                                            $modalId = "viewdocument_modal_" . $row['id']; // Unique modal ID
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $i++ ?></th>
                                                <td><?php echo $row['title'] ?> </td>
                                                <td> <?php echo $row['subject'] ?> </td>
                                                <td><?php echo date("m-d-y H:i:s A", strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <a href="" class="btn btn-outline-primary">Edit</a>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>">View</button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- Adjust modal size if needed -->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-4" id="exampleModalLabel_<?php echo $row['id']; ?>">Document Details</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                
                                                                    <?php if ($row['document_type'] == 'image/jpg' || $row['document_type'] == 'image/jpeg' || $row['document_type'] == 'image/png') { ?>
                                                                        <img src="displayDocument.php?id=<?php echo $row['id'] ?>" class="img-fluid" alt="Not Found">
                                                                    <?php } else if ($row['document_type'] == 'application/pdf') { ?>
                                                                        
                                                                        <a href="<?php echo BASE_URL ?>notices/displayDocument.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">Click here to view</a>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a href="" class="btn btn-outline-danger">Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="5">No Records Found</td>
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