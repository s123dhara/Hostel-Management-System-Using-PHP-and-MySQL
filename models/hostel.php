<?php 
function createHostel($conn, $params){
    extract($params);

    $datetime = date("Y-m-d H:i:s");
    $sql = "INSERT INTO hostels(hostel_number, total_rooms, created_at) 
            VALUES('$hostel_number', '$total_rooms', '$datetime')";

    $res = $conn->query($sql);
    return $res;
}