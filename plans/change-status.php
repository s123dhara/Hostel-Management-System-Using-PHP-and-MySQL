<?php include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");
include_once(DIR_URL . "models/plan.php");
include_once(DIR_URL . "models/room.php");



#update status & rooms
if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'status') {
    $ID = intval($_GET['id']);  // Sanitize input

    // Determine the new status based on the current status passed in the URL
    if ($_GET['status'] == 'Active') {
        $newStatus = 'Inactive';
    } else {
        $newStatus = 'Active';
    }

    // Prepare the SQL query to update the status
    $sql = "UPDATE plans SET status = '$newStatus' WHERE id = $ID";
    $res = $conn->query($sql);

    // Redirect to the plans page after updating the status
    if ($res) {
        header("LOCATION: " . BASE_URL . "plans");
        exit;
    } else {
        // Handle query failure
        echo "Error updating status.";
    }
}

?>

