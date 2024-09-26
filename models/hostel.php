<?php

function createHostel($conn, $params)
{
    // Extract the values from the $params array into variables
    extract($params);

    // Validate the required fields
    if (empty($hostel_number)) {
        return array("error" => "Hostel number is required");
    } else if (empty($total_rooms)) {
        return array("error" => "Valid number of total rooms is required");
    }

    // Check if the hostel with the same number already exists
    $check_sql = "SELECT hostel_number FROM hostels WHERE hostel_number = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $hostel_number);  // Bind the hostel_number as a string
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        return array("error" => "A hostel with this number already exists");
    }

    // Proceed to insert if no duplicate is found
    $datetime = date("Y-m-d H:i:s");
    $sql = "INSERT INTO hostels (hostel_number, total_rooms, created_at) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $hostel_number, $total_rooms, $datetime);  // 'sis' means string, integer, string

    // Execute the insert query
    $res = $stmt->execute();

    // Return the result of the operation
    if ($res) {
        return array("success" => true);
    } else {
        return array("error" => "Failed to create the hostel");
    }
}


function getHostels($conn)
{
    $sql = "SELECT id, hostel_number FROM hostels";
    $res = $conn->query($sql);
    return $res;
}


function getHostelById($conn, $id) {
    $sql = "select * from hostels where id = $id";
    $result = $conn->query($sql);
    return $result;
}