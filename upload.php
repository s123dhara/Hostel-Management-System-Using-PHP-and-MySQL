<?php
include_once("config/config.php");
include_once("config/database.php");

if (isset($_FILES['image'])) {
    $image = $_FILES['image']['tmp_name'];
    $imgData = file_get_contents($image); // Read image content as binary data

    // Insert image into the database
    $sql = "INSERT INTO documents (photo) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("b", $imgData); // Bind the binary data
    $stmt->send_long_data(0, $imgData); // Send the binary data

    if ($stmt->execute()) {
        echo "Image uploaded successfully.";
    } else {
        echo "Failed to upload image.";
    }
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
</head>
<body>
    <h1>Upload an Image</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" required>
        <button type="submit">Upload Image</button>
    </form>
</body>
</html>

