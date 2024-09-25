<?php 


function getEnumValues($conn, $table, $column) {
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


function createRoom($conn, $params) {
    // Extract the values from the $params array into variables
    extract($params);

    // First, find the hostel_id using the hostel_number
    $find_hostel_id_query = "SELECT id FROM hostels WHERE hostel_number = '$hostel_number'";
    
    // Execute the query
    $result = $conn->query($find_hostel_id_query);

    // Check if any result was returned
    if ($result && $result->num_rows > 0) {
        // Fetch the hostel_id
        $hostel_id_row = $result->fetch_assoc();
        $hostel_id = $hostel_id_row['id'];  // Access the 'id' key from the result
    } else {
        // If no hostel was found, return an error or handle accordingly
        echo "Hostel with number $hostel_number not found.";
        exit;
    }

    // Prepare the date and time
    $datetime = date("Y-m-d H:i:s");

    // Now, insert the new room into the rooms table
    $sql = "INSERT INTO rooms (hostel_id, room_number, floor_number, room_type, created_at) 
            VALUES ($hostel_id, '$room_number', '$floor_number', '$room_type', '$datetime')";

    // Execute the insert query
    $res = $conn->query($sql);

    // Return the result of the insert operation (true/false)
    return $res;
}
