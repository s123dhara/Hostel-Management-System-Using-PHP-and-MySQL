<?php

use function PHPSTORM_META\type;

function createPlan($conn, $params)
{

    // Extract parameters from the $params array
    extract($params);

    // Validate required fields
    if (!isset($title) || empty($title)) {
        return array('error' => "Title is required");
    }

    if (!isset($duration) || empty($duration)) {
        return array('error' => "Duration is required");
    }

    if (!isset($price) || empty($price)) {
        return array('error' => "Price is required");
    }

    // Prepare the SQL query for insertion
    $sql = "INSERT INTO plans (title, duration, price) VALUES (?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssi", $title, $duration, $price); // Assuming duration is a string and price is an integer

    // Execute the statement
    if ($stmt->execute()) {
        return array('success' => "Plan created successfully");
    } else {
        return array('error' => "Error creating plan: " . $stmt->error);
    }
}


function getPlans($conn)
{
    $SQL = "SELECT * FROM plans";
    $stmt = $conn->prepare($SQL);
    $res = $stmt->execute();
    // Fetch all the room details as an associative array
    $result = $stmt->get_result();
    $plans = $result->fetch_all(MYSQLI_ASSOC);

    return $plans;
}


function getAllStatus($conn)
{
    // Query to get the ENUM values for the 'status' column in the 'plans' table
    $sql = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'plans' AND COLUMN_NAME = 'status'";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        // Get the ENUM values as a string like: enum('Active','Inactive')
        $enumStr = $row['COLUMN_TYPE'];

        // Remove "enum(" and the closing ")" to get just the values
        $enumStr = str_replace("enum('", "", $enumStr);
        $enumStr = str_replace("')", "", $enumStr);

        // Now explode the values into an array
        $statusOptions = explode("','", $enumStr);

        return $statusOptions;
    }
}


function setStatus($conn, $id, $type)
{
    // Prepare the SQL update statement to set the status

    $type = intval($type);
    $sql = "update plans set status = $type  where id = $id";
    $result = $conn->query($sql);

    // Execute the statement
    if ($result) {
        return array('success' => 'Status updated successfully');
    } else {
        return array('error' => 'Failed to update status');
    }
}

function getAllPlans($conn)
{
    $SQL = "SELECT * FROM plans";
    $res = $conn->query($SQL);
    return $res;
}

function getPlanById($conn, $id)
{
    $SQL = "SELECT * FROM plans WHERE id = $id";
    $res = $conn->query($SQL);
    $res = $res->fetch_assoc();
    return $res;
}

function getAllPlans_price($conn)
{
    $SQL = "SELECT duration FROM plans";
    $res = $conn->query($SQL);
    return $res;
}

function createBooking_by_admin($conn, $postData, $getData)
{

    // Extract data from POST and GET
    $studentId = intval($getData['id']); // Ensure this is an integer
    $roomId = intval($getData['room_id']); // Ensure this is an integer
    $plan_title_id = intval($postData['plan_title_id'] ?? 0); // Default to an empty string if not set
    $duration = $postData['duration']; // Ensure this is an integer
    $checkInDate = $postData['check_in_date'] ?? ''; // Get the check-in date from POST



    // Calculate check-out date by adding the duration in months
    if (!empty($checkInDate)) {
        $checkInDateObj = new DateTime($checkInDate); // Create DateTime object

        // Ensure $duration is an integer
        $duration = intval($duration); // Convert duration to an integer

        // Create the string with the correct format
        $incrementMonths = "$duration months"; // Correct the format

        // Add duration in months
        $checkInDateObj->modify("+$incrementMonths");

        // Format to MySQL date format
        $checkOutDate = $checkInDateObj->format('Y-m-d');
    } else {
        return array('error' => "Check-in date is required.");
    }

    // echo "<pre>";
    // var_dump($checkOutDate);
    // var_dump($checkInDate); // Check input date
    // var_dump($duration); // Check duration
    // var_dump($incrementMonths); // Check the increment string
    // exit;


    // Prepare the SQL query to insert the booking
    $sql = "INSERT INTO bookings (plan_id, student_id, room_id, check_in_date, check_out_date) VALUES (?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Check if statement preparation is successful
    if ($stmt === false) {
        return array('error' => "Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param('iiiss', $plan_title_id, $studentId, $roomId, $checkInDate, $checkOutDate);

    // Execute the statement
    if ($stmt->execute()) {

        $booking_id = $stmt->insert_id;

        $SQL = "UPDATE students SET payment_status = 1, booking_id = $booking_id WHERE id = $studentId";
        $res = $conn->query($SQL);

        return array('success' => "Booking created successfully!");
    } else {
        return array('error' => "Error executing statement: " . $stmt->error);
    }
}


function getPlanStatus($conn, $plan_id) {
    // Query to get the check_in_date and check_out_date for the plan
    $sql = "SELECT check_in_date, check_out_date FROM bookings WHERE plan_id = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        return array('error' => "Error preparing statement: " . $conn->error);
    }
    
    // Bind the plan ID
    $stmt->bind_param('i', $plan_id);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if the plan exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Extract check-in and check-out dates
        $checkInDate = new DateTime($row['check_in_date']);
        $checkOutDate = new DateTime($row['check_out_date']);
        // $currentDate = new DateTime(); // Get the current date --->SET IT 

        $currentDate = new DateTime("2024-10-15"); // Get the current date
        
        // Determine the status
        if ($currentDate >= $checkInDate && $currentDate <= $checkOutDate) {
            return 'Active'; // Current date is between check-in and check-out
        } elseif ($currentDate > $checkOutDate) {
            return 'Expired'; // Current date is after check-out
        } elseif ($currentDate < $checkInDate) {
            return 'Advance'; // Current date is before check-in
        }
    } else {
        return array('error' => "Plan not found.");
    }
}


function findPlanIdAndDate($conn, $student_id) {
    // Get current date
    // $currentDate = date('Y-m-d');
    $currentDate = date('Y-m-d', strtotime("2024-10-15"));
    
    // SQL query to find the active plan for the student
    $SQL = "SELECT plan_id, check_in_date, check_out_date 
            FROM bookings 
            WHERE student_id = ? 
            AND check_in_date <= ? 
            AND check_out_date >= ?";

    // Prepare the statement
    $stmt = $conn->prepare($SQL);
    
    if ($stmt === false) {
        return array('error' => "Error preparing statement: " . $conn->error);
    }
    
    // Bind the parameters (student_id, currentDate, currentDate)
    $stmt->bind_param('iss', $student_id, $currentDate, $currentDate);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if an active plan is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row; // Return the active plan ID
    } else {
        return null; // No active plan found
    }
}
