<?php
include_once("./config.php");
$conn = @new mysqli(SERVER_NAME, USERNAME, PASSWORD, DATABASE);
//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connection Succesful";
}
?>