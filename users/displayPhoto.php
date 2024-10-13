<?php
include_once("../config/config.php");
include_once("../config/database.php");

// Check if an ID and type (photo or id_proof) are passed
if (isset($_GET['id']) && isset($_GET['type'])) {
    $image_id = intval($_GET['id']);
    $image_type = $_GET['type'];

    // Define the query based on the image type
    switch ($image_type) {
        case 'photo':
            $query = "SELECT photo, photo_type FROM documents WHERE id = ?";
            break;
        case 'id_proof':
            $query = "SELECT id_proof, id_proof_type FROM documents WHERE id = ?";
            break;
        case 'admission_receipt':
            $query = "SELECT admission_receipt, admission_receipt_type FROM documents WHERE id = ?";
            break;
        case 'profile_pic':
            $query = "SELECT profile_pic, profile_pic_type FROM users WHERE id = ?";
            break;
        default:
            echo "Invalid image type.";
            exit;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $stmt->bind_result($image_data, $mime_type);

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
