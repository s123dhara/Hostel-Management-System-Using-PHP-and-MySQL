<?php

function getEnumValues($conn, $table, $column)
{
    // Query to fetch the column definition
    $sql = "SHOW COLUMNS FROM $table LIKE '$column'";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $enumValues = $row['Type']; // This will contain the ENUM definition, like enum('Single','Double','Triple')

        // Extract the values from the ENUM definition
        preg_match("/^enum\(\'(.*)\'\)$/", $enumValues, $matches);
        $enumValuesArray = explode("','", $matches[1]); // Split the values into an array

        return $enumValuesArray; // Return the array of enum values
    }
    return [];
}

function createRoom($conn, $params)
{
    // Extract the values from the $params array into variables
    extract($params);

    #validation Start
    if (empty($hostel_id)) {
        return array("error" => "Hostel Number is required");
    } else if (empty($room_number)) {
        return array("error" => "Valid Room Number is required");
    } else if (isRoomnoUnique($conn, $room_number, $hostel_id)) {
        return array("error" => "Room Number Already Exists");
    } else if (empty($room_type)) {
        return array("error" => "Room type is Required");
    }
    else if (empty($max_occupancy)) {
        return array("error" => "Max Occupancy is Required");
    }

    // Prepare the date and time
    $datetime = date("Y-m-d H:i:s");

    // Prepare the SQL query using prepared statements
    $sql = "INSERT INTO rooms (hostel_id, room_number, floor_number, room_type, max_occupancy ,created_at) 
            VALUES (?, ?, ?, ?, ? ,?)";

    // Use a prepared statement to execute the query securely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $hostel_id, $room_number, $floor_number, $room_type, $max_occupancy ,$datetime);

    // Execute the insert query and check for success
    $res = $stmt->execute();

    // Return the result of the insert operation
    if ($res) {
        return array("success" => true);
    } else {
        return array("error" => "Failed to create the room");
    }
}

function isRoomnoUnique($conn, $room_number, $hostel_id, $room_id = null)
{
    // Modify the SQL to exclude the current room being updated (if room_id is provided)
    $sql = "SELECT room_number FROM rooms WHERE hostel_id = ? AND room_number = ?";
    if ($room_id) {
        $sql .= " AND id != ?";
    }

    $stmt = $conn->prepare($sql);
    if ($room_id) {
        $stmt->bind_param("isi", $hostel_id, $room_number, $room_id);
    } else {
        $stmt->bind_param("is", $hostel_id, $room_number);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Return true if a room with the same number exists, false otherwise
    return $result->num_rows > 0;
}


function getRooms($conn)
{

    $sql = "SELECT r.*, h.hostel_number FROM rooms r, hostels h WHERE r.hostel_id = h.id";
    $stmt = $conn->prepare($sql);
    $res = $stmt->execute();
    // Fetch all the room details as an associative array
    $result = $stmt->get_result();
    $rooms = $result->fetch_all(MYSQLI_ASSOC);
    // echo "<pre>";
    // print_r($rooms);
    // exit;
    return $rooms;
}

function getStatus($conn, $room)
{

    $result = getEnumValues($conn, "rooms", "room_status");
    $id = $room['id'];
    $sql = "SELECT room_status FROM rooms WHERE id = $id";
    $res = $conn->query($sql);
    $resutl_status = $res->fetch_assoc();
    // echo"<pre>";
    // print_r($status['room_status']);
    // exit;
    if ($resutl_status['room_status'] == "Under Maintenance") {
        return $resutl_status['room_status'];
    }


    $Available = $result[0];
    $Occupied = $result[1];
    $room_type = $room['room_type'];
    $current_occupancy = $room['current_occupancy'];

    if ($room_type == 'Single' && $current_occupancy == 1) {
        return $Occupied;
    } else if ($room_type == 'Double' && $current_occupancy == 2) {
        return $Occupied;
    } else if ($room_type == 'Triple' && $current_occupancy == 3) {
        return $Occupied;
    } else {
        return $Available;
    }
}


function getRoomById($conn, $id)
{
    $sql = "select * from rooms where id = $id";
    $result = $conn->query($sql);
    return $result;
}


function updateRoom($conn, $params, $id)
{
    // Extract the values from the $params array into variables
    extract($params);
    // echo "<pre>";
    // print_r($params);
    // exit;

    // Validation Start
    if (empty($hostel_id)) {
        return array("error" => "Hostel Number is required");
    } else if (empty($room_number)) {
        return array("error" => "Valid Room Number is required");
    } else if (empty($room_type)) {
        return array("error" => "Room type is required");
    } 

    // Check if the room number already exists in the same hostel, but exclude the current room (update scenario)
    $existingRoom = isRoomnoUnique($conn, $room_number, $hostel_id, $id);
    if ($existingRoom) {
        return array("error" => "Room Number Already Exists");
    }

    // Prepare the date and time for the updated_at field
    $datetime = date("Y-m-d H:i:s");

    // Prepare the SQL update query using prepared statements
    $sql = "UPDATE rooms 
            SET hostel_id = ?, room_number = ?, floor_number = ?, room_status=?  ,room_type = ?, updated_at = ?
            WHERE id = ?";
    // echo "<pre>";
    // print_r($sql);
    // exit;
    // Use a prepared statement to execute the query securely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssi", $hostel_id, $room_number, $floor_number, $room_status ,$room_type, $datetime, $id);

    // Execute the update query and check for success
    $res = $stmt->execute();

    // Return the result of the update operation
    if ($res) {
        return array("success" => true);
    } else {
        return array("error" => "Failed to update the room");
    }
}


function deleteBook($conn, $id){
    $sql = "DELETE FROM rooms WHERE id = $id";
    $result = $conn->query($sql);
    return $result;
}