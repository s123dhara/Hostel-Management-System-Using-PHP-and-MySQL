<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/middleware.php");
include_once(DIR_URL . "models/hostel.php");
include_once(DIR_URL . "models/room.php");
include_once(DIR_URL . "models/student.php");

if (isset($_GET['id']) && isset($_GET['type'])) {

    // 1. APPROVE & ASSIGN 
    $approve_result = update_student_status($conn, $_GET['type'], $_GET['id']);
    if (!$approve_result) {
        $_SESSION['error'] = "Something Went Wrong for updating the Status";
        header("Location: " . BASE_URL . "students/pending-request.php"); // Fixing the URL concatenation
        exit;
    }

    // Assign room number part
    $assign_room_number_result = assign_room_number($conn, $_GET['id']);
    
    if (isset($assign_room_number_result['error'])) {
        $_SESSION['error'] = $assign_room_number_result['error'];
        header("Location: " . BASE_URL . "students/pending-request.php"); // Fixing the URL concatenation
        exit;
    }

    if (isset($assign_room_number_result['success'])) {
        $_SESSION['success'] = $assign_room_number_result['success'];
        header("Location: " . BASE_URL . "students/pending-request.php"); // Fixing the URL concatenation
        exit;
    }

}

// Default redirection if none of the conditions match
header("Location: " . BASE_URL . "students/pending-request.php"); // Fixing the URL concatenation
exit;

?>
