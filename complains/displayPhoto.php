<?php
include_once("../config/config.php");
include_once("../config/database.php");

include_once(DIR_URL . "include/admin_middleware.php");

if (isset($_GET)  && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT supported_docs, supported_docs_type FROM complains WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->bind_result($image_data, $mime_type);

    if ($stmt->fetch()) {
        // Set the appropriate content type header based on the MIME type
        header("Content-Type: $mime_type");
        echo $image_data; // Output the binary data of the image
    } else {
        echo "Image not found.";
    }
} else {
    echo "Image ID or type not provided.";
}
