<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");


# Post Request to update room details
if (isset($_POST['update_room'])) {
    $res = updateRoom($conn, $_POST, $_GET['id']);

    if (isset($res['success'])) {
        $_SESSION['success'] = "Room has been updated successfully";
        header("Location: " . BASE_URL . "rooms");
        exit;
    } else {
        $_SESSION['error'] = $res['error'];
        header("Location: " . BASE_URL . "rooms/edit-room.php");
        exit;
    }
}

// Read get parameter to get Hostel & room data
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $room = getRoomById($conn, $_GET['id']);
    $hostel = "";
    if ($room->num_rows > 0) {
        $room = mysqli_fetch_assoc($room);
        $hostel = getHostelById($conn, $room['hostel_id']);
        $hostel = mysqli_fetch_assoc($hostel);
    }
} else {
    header("LOCATION: " . BASE_URL . "rooms");
    exit;
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
                <h4 class="fw-bold text-uppercase">Update Room</h4>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Fill the form
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo BASE_URL ?>rooms/edit-room.php?id=<?php echo $room['id'] ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Hostel Number</label>
                                        <?php $hostels = getHostels($conn); ?>

                                        <Select name="hostel_id" class="form-control">
                                            <option value="">Please Select</option>
                                            <?php
                                            $selected = "";
                                            while ($row = $hostels->fetch_assoc()) {
                                                if ($row['id'] === $hostel['id']) {
                                                    $selected = "selected";
                                                }

                                            ?>
                                                <option <?php echo $selected ?> value="<?php echo $row['id'] ?>"> <?php echo $row['hostel_number'] ?> </option>
                                            <?php } ?>
                                        </Select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Room Number</label>
                                        <input type="text" name="room_number" class="form-control" value="<?php echo $room['room_number'] ?>" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Floor Number</label>
                                        <input type="text" name="floor_number" class="form-control" value="<?php echo $room['floor_number'] ?>" required />
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Room Status</label>
                                        <?php
                                        // Fetch the ENUM values for room types
                                        $roomStatuses = getEnumValues($conn, 'rooms', 'room_status');
                                        ?>

                                        <select name="room_status" class="form-control" required>
                                            <option value="">Please select</option>
                                            <?php
                                            foreach ($roomStatuses as $status) {
                                                // Reset the $selected variable for each iteration
                                                $selected = ($status === $room['room_status']) ? "selected" : "";
                                            ?>
                                                <option <?php echo $selected ?> value="<?php echo $status; ?>">
                                                    <?php echo $status; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Room Type</label>
                                        <?php
                                        // Fetch the ENUM values for room types
                                        $roomTypes = getEnumValues($conn, 'rooms', 'room_type');
                                        ?>

                                        <select name="room_type" class="form-control" required>
                                            <option value="">Please select</option>
                                            <?php
                                            foreach ($roomTypes as $type) {
                                                // Reset the $selected variable for each iteration
                                                $selected = ($type === $room['room_type']) ? "selected" : "";
                                            ?>
                                                <option <?php echo $selected ?> value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <button name="update_room" type="submit" class="btn btn-primary">
                                        Update
                                    </button>

                                    <a href="<?php echo BASE_URL ?>rooms" class="btn btn-secondary">Cancel</a>
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


<?php include_once(DIR_URL . "include/footer.php") ?>