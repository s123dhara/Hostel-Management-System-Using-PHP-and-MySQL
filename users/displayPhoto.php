<?php
include_once("../config/config.php");
include_once("../config/database.php");

// Check if an ID and type (photo or id_proof) are passed
if (isset($_GET['id']) && isset($_GET['type'])) {
    $image_id = intval($_GET['id']);
    $image_type = $_GET['type'];

    // Fetch the correct image and its MIME type based on the 'type' parameter
    if ($image_type == 'photo') {
        $query = "SELECT photo, photo_type FROM documents WHERE id = ?";
    } else if ($image_type == 'id_proof') {
        $query = "SELECT id_proof, id_proof_type FROM documents WHERE id = ?";
    }
    else if ($image_type == 'admission_receipt') {
        $query = "SELECT admission_receipt, admission_receipt_type FROM documents WHERE id = ?";
    }
    else {
        echo "Invalid image type.";
        exit;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    
    // Fetch both image data and its MIME type
    if ($image_type == 'photo') {
        $stmt->bind_result($image_data, $mime_type);
    } else if ($image_type == 'id_proof') {
        $stmt->bind_result($image_data, $mime_type);
    }else if($image_type == 'admission_receipt') {
        $stmt->bind_result($image_data, $mime_type);
    }

    if ($stmt->fetch()) {
        // Set the appropriate content type header based on the MIME type
        header("Content-Type: $mime_type");
        echo $image_data; // Output the binary data of the image
    } else {
        echo "Image not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Image ID or type not provided.";
}

?>
