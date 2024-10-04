<?php

function addNewComplain($conn, $files, $params, $student_id)
{
    
    extract($params);
    $supported_docs = $files['supported_docs'];

    // Allowed formats for images
    $allowed_formats = ['image/png', 'image/jpeg', 'image/jpg'];

    if (empty($name)) {
        $result['error'] = "Name is required.";
        return $result;
    }
    if (empty($subject)) {
        $result['error'] = "Subject is required.";
        return $result;
    }
    if (empty($issue)) {
        $result['error'] = "Complaint Issue required.";
        return $result;
    }

    // Handle file uploads
    $supported_docs_result = handle_file_upload($supported_docs, $allowed_formats, "supported_docs");
    if (isset($supported_docs_result['error'])) {
        return ['error' => $supported_docs_result['error']];
    }

    $datetime = date("Y-m-d H:i:s");
    $st = 0;
    $sql = "INSERT INTO complains (name, student_id ,subject, issue, status ,created_at) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $name, $student_id ,$subject, $issue,$st ,$datetime);

    if ($stmt->execute()) {
        $complain_id = intval($stmt->insert_id);
        $sql = "UPDATE complains SET supported_docs = ?, supported_docs_type = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("bsi", $supported_docs_result['content'], $supported_docs['type'] ,$complain_id);
        $stmt->send_long_data(0, $supported_docs_result['content']);
        if ($stmt->execute()) {
            $result['success'] = true;
        } else {
            $result['error'] = "Failed to Upload docs";
        }
    }else {
        $result['error'] = "Failed to create record.";
    }

    return $result;

}

function getAllComplainsBy_studentId($conn, $student_id) {
    $SQL = "SELECT * FROM complains WHERE student_id = $student_id";
    $res = $conn->query($SQL);
    return $res;
}


function getAllComplains($conn) {
    $SQL = "SELECT * FROM complains WHERE status = 0";
    $res = $conn->query($SQL);
    return $res;
}