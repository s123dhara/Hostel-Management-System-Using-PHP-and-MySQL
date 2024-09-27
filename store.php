<?php
include_once("config/config.php");
include_once("config/database.php");

// Fetch all image IDs
$query = "SELECT id FROM documents";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display All Images</title>
</head>
<body>

    <h1>All Images</h1>

    <?php
    if ($result->num_rows > 0) {
        // Loop through all images and display both photo and id_proof
        while ($row = $result->fetch_assoc()) {
            $image_id = $row['id'];
    ?>
            <div style="margin-bottom: 20px;">
                <h3>Record ID: <?php echo $image_id; ?></h3>
                <!-- Display photo -->
                <img src="display_image.php?id=<?php echo $image_id; ?>&type=photo" alt="Photo for ID <?php echo $image_id; ?>" style='width: 250px; height:150px; margin: 10px;'>
                
                <!-- Display ID proof -->
                <img src="display_image.php?id=<?php echo $image_id; ?>&type=id_proof" alt="ID Proof for ID <?php echo $image_id; ?>" style='width: 250px; height:150px; margin: 10px;'>
            </div>
    <?php
        }
    } else {
        echo "<p>No images found in the database.</p>";
    }

    // Close the connection
    $conn->close();
    ?>

</body>
</html>
