
<?php

function addNewNotice($conn, $files, $params)
{
    echo "<pre>";
    print_r($_FILES);
    print_r($params);
    // exit;

    extract($params);
    $supported_docs = $files['document'];

    // Allowed formats for images
    $allowed_formats = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf'];

    if (empty($title)) {
        $result['error'] = "Name is required.";
        return $result;
    }
    if (empty($subject)) {
        $result['error'] = "Subject is required.";
        return $result;
    }
   

    // Handle file uploads
    $supported_docs_result = handle_file_upload($supported_docs, $allowed_formats, "document");
    if (isset($supported_docs_result['error'])) {
        return ['error' => $supported_docs_result['error']];
    }

    $datetime = date("Y-m-d H:i:s");
    $st = 0;
    $sql = "INSERT INTO notices (title, subject,created_at) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $subject, $datetime);

    if ($stmt->execute()) {
        $notice_id = intval($stmt->insert_id);
        $sql = "UPDATE notices SET document = ?, document_type = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("bsi", $supported_docs_result['content'], $supported_docs['type'], $notice_id);
        $stmt->send_long_data(0, $supported_docs_result['content']);
        if ($stmt->execute()) {
            $result['success'] = true;
        } else {
            $result['error'] = "Failed to Upload docs";
        }
    } else {
        $result['error'] = "Failed to create record.";
    }

    return $result;
}


function getAllNotices($conn) {

    $SQL = "SELECT * FROM notices ORDER BY created_at DESC";
    $res = $conn->query($SQL);
    return $res;

}