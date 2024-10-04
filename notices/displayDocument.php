<?php
include_once("../config/config.php");
include_once("../config/database.php");

if (isset($_GET) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT document, document_type FROM notices WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->bind_result($file_data, $mime_type);

    if ($stmt->fetch()) {
        // Set the appropriate content type header based on the MIME type
        header("Content-Type: $mime_type");

        // For PDF files, inline display
        if ($mime_type == "application/pdf") {
            header("Content-Disposition: inline; filename=document.pdf");
        }

        echo $file_data; // Output the binary data of the document (PDF or image)
    } else {
        echo "File not found.";
    }
} else {
    echo "File ID not provided.";
}
