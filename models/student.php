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
    // echo "<pre>";
    // print_r($params);
    // exit;

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


    $id_proof = $_FILES['id_proof'];
    $admission_receipt = $_FILES['admission_receipt'];
    $photo = $_FILES['photo'];

    // Validate file uploads
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


    // Handle each file upload
    $id_proof_result = handle_file_upload($id_proof);
    if (isset($id_proof_result['error'])) {
        return ['error' => $id_proof_result['error']];
    }

    $admission_receipt_result = handle_file_upload($admission_receipt);
    if (isset($admission_receipt_result['error'])) {
        return ['error' => $admission_receipt_result['error']];
    }

    $photo_result = handle_file_upload($photo);
    if (isset($photo_result['error'])) {
        return ['error' => $photo_result['error']];
    }

    // If all required fields are present, proceed with inserting into database
    // Insert the record into the database (example query)

    $datetime = date("Y-m-d H:i:s");
    $dob_mysql = date("Y-m-d", strtotime($date_of_birth));
    $admission_date_mysql = date("Y-m-d", strtotime($admission_date));
    // If all required fields are present, proceed with inserting into database
    // Insert the record into the database (example query)
    $stmt = $conn->prepare("INSERT INTO students (first_name, middle_name, last_name, date_of_birth, gender, email, guardian_name, guardian_phone_number, guardian_relationship,address, state, pincode, institute_name, semester, stream, course, admission_date, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssss", $first_name, $middle_name, $last_name, $dob_mysql, $gender, $email, $guardian_name, $guardian_phone_number, $guardian_relationship, $address, $state, $pincode, $institute_name, $semester, $stream, $course, $admission_date_mysql, $datetime);


    if ($stmt->execute()) {
        // $result['success'] = "Student record created successfully.";

        // $student_id = $stmt->insert_id;

        $sql = "INSERT INTO documents(photo,admission_receipt,id_proof)
                VALUES(?, ?, ?)";
        
        $stmt = $conn->query($sql);
        $stmt->bind_param("bbb", $photo_result['content'], $admission_receipt_result['content'], $id_proof_result['content']);
        
        $stmt->send_long_data(0, $photo_result);
        $stmt->send_long_data(0, $admission_receipt_result);
        $stmt->send_long_data(0, $id_proof_result);
        if ($stmt->execute()) {
            $result['success'] = "Student record created successfully.";
        } else {
            $result['error'] = "erorrrrrrrrrrrrrrrr.";
        }

        // $sql = "UPDATE students SET document_id = $document_id WHERE id = "

        $stmt->close();    

    } else {
        $result['error'] = "Failed to create student record.";
    }

    return $result;
}


function handle_file_upload($file)
{
    // Check if there was an upload error
    // if ($file['error'] !== UPLOAD_ERR_OK) {
    //     return ['error' => "File upload error: " . $file['error']];
    // }

    // // Check file type
    // if (!in_array($file['type'], $GLOBALS['allowed_formats'])) {
    //     return ['error' => "Invalid file format. Only .png, .jpg, and .jpeg are allowed."];
    // }

    // Read the file content into a variable
    $file_content = file_get_contents($file['tmp_name']);
    return ['content' => $file_content];
}

