<?php

// For Log in from User-Student Side
function createStudent($conn, $params)
{
    // Extract parameters into individual variables
    extract($params);

    // Prepare the current date and time for 'created_at'
    $datetime = date("Y-m-d H:i:s");

    // Prepare the SQL insert query for the `students` table
    $sql = "INSERT INTO students (first_name, last_name, email, created_at) 
            VALUES (?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $datetime);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Get the last inserted student ID
        $student_id = $stmt->insert_id;

        // Hash the password before inserting into the users table
        // $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into the `users` table
        $sql = "INSERT INTO users (student_id, email, password, created_at) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $student_id, $email, $password, $datetime);

        // Execute the second insert and check if successful
        if ($stmt->execute()) {
            // Fetch the inserted user data if needed (in this case, just returning success)
            return array("success" => true, "student_id" => $student_id);
        } else {
            return array("error" => "Failed to insert user: " . $stmt->error);
        }
    } else {
        // Handle errors for student insert
        return array("error" => "Failed to insert student: " . $stmt->error);
    }
}

function create_student_by_admin($conn, $params, $files)
{
    $result = array('success' => '', 'error' => '');

    // Extract all fields from the $params array
    $first_name      = $params['first_name'];
    $middle_name     = $params['middle_name'];
    $last_name       = $params['last_name'];
    $date_of_birth   = $params['date_of_birth'];
    $gender          = $params['gender'];
    $email           = $params['email'];
    $guardian_name   = $params['guardian_name'];
    $guardian_phone_number = $params['guardian_phone_number'];
    $guardian_relationship = $params['guardian_relationship'];
    $address         = $params['address'];
    $state           = $params['state'];
    $pincode         = $params['pincode'];
    $institute_name  = $params['institute_name'];
    $semester        = $params['semester'];
    $stream          = $params['stream'];
    $course          = $params['course'];
    $admission_date  = $params['admission_date'];

    // File uploads
    $id_proof = $files['id_proof'];
    $admission_receipt = $files['admission_receipt'];
    $photo = $files['photo'];

    // Allowed formats for images
    $allowed_formats = ['image/png', 'image/jpeg', 'image/jpg'];

    // Validate each required field
    if (empty($first_name)) {
        $result['error'] = "First Name is required.";
        return $result;
    }
    if (empty($last_name)) {
        $result['error'] = "Last Name is required.";
        return $result;
    }
    if (empty($date_of_birth)) {
        $result['error'] = "Date of Birth is required.";
        return $result;
    }
    if (empty($gender)) {
        $result['error'] = "Gender is required.";
        return $result;
    }
    if (empty($email)) {
        $result['error'] = "Email is required.";
        return $result;
    }
    if (empty($guardian_name)) {
        $result['error'] = "Guardian Name is required.";
        return $result;
    }
    if (empty($address)) {
        $result['error'] = "Address is required.";
        return $result;
    }
    if (empty($state)) {
        $result['error'] = "State is required.";
        return $result;
    }
    if (empty($pincode)) {
        $result['error'] = "Pincode is required.";
        return $result;
    }
    if (empty($institute_name)) {
        $result['error'] = "Institute Name is required.";
        return $result;
    }
    if (empty($semester)) {
        $result['error'] = "Semester is required.";
        return $result;
    }
    if (empty($stream)) {
        $result['error'] = "Stream is required.";
        return $result;
    }
    if (empty($course)) {
        $result['error'] = "Course is required.";
        return $result;
    }
    if (empty($admission_date)) {
        $result['error'] = "Admission Date is required.";
        return $result;
    }

    // Handle file uploads
    $id_proof_result = handle_file_upload($id_proof, $allowed_formats, "ID Proof");
    if (isset($id_proof_result['error'])) {
        return ['error' => $id_proof_result['error']];
    }

    $admission_receipt_result = handle_file_upload($admission_receipt, $allowed_formats, "Admission Receipt");
    if (isset($admission_receipt_result['error'])) {
        return ['error' => $admission_receipt_result['error']];
    }

    $photo_result = handle_file_upload($photo, $allowed_formats, "Photo");
    if (isset($photo_result['error'])) {
        return ['error' => $photo_result['error']];
    }

    // Insert the document record into the database
    $datetime = date("Y-m-d H:i:s");
    $sql = "INSERT INTO documents (photo, admission_receipt, id_proof, photo_type, admission_receipt_type, id_proof_type, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("bbbssss", $photo_result['content'], $admission_receipt_result['content'], $id_proof_result['content'], $photo['type'], $admission_receipt['type'], $id_proof['type'], $datetime);

    $stmt->send_long_data(0, $photo_result['content']);
    $stmt->send_long_data(1, $admission_receipt_result['content']);
    $stmt->send_long_data(2, $id_proof_result['content']);

    // Execute the statement
    if ($stmt->execute()) {
        $document_id = $stmt->insert_id;

        // Prepare and execute the student insertion query
        $dob_mysql = date("Y-m-d", strtotime($date_of_birth));
        $admission_date_mysql = date("Y-m-d", strtotime($admission_date));

        $stmt = $conn->prepare("INSERT INTO students (first_name, middle_name, last_name, date_of_birth, gender, email, guardian_name, guardian_phone_number, guardian_relationship, address, state, pincode, institute_name, semester, stream, course, admission_date, created_at, document_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssssssssssssssssss", $first_name, $middle_name, $last_name, $dob_mysql, $gender, $email, $guardian_name, $guardian_phone_number, $guardian_relationship, $address, $state, $pincode, $institute_name, $semester, $stream, $course, $admission_date_mysql, $datetime, $document_id);

        if ($stmt->execute()) {
            $result['success'] = true;
        } else {
            $result['error'] = "Failed to create student record.";
        }
    } else {
        $result['error'] = "Failed to upload documents.";
    }

    return $result;
}

// File upload handler function
function handle_file_upload($file, $allowed_formats, $name)
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => "File upload error: " . $file['error']];
    }

    if (!in_array($file['type'], $allowed_formats)) {
        return ['error' => "$name: Invalid file format. Only .png, .jpg, and .jpeg are allowed."];
    }

    // Size limits (0 KB to 100 KB)
    $minSize = 0;  // 0 KB in bytes
    $maxSize = 102400; // 100 KB in bytes

    if ($file['size'] < $minSize || $file['size'] > $maxSize) {
        return ['error' => "$name: File size must be between 51 KB and 100 KB."];
    }

    // Get the file content
    $file_content = file_get_contents($file['tmp_name']);
    return ['content' => $file_content];
}


function getAllStudents($conn) {
    // $sql = "SELECT id,first_name, last_name, stream, course, semester FROM students";
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);
    return $result;
}