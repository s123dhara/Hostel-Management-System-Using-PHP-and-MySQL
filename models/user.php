<?php
function getUserByEmail($conn, $email)
{
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");

    // Bind the email parameter
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $res = $stmt->get_result()->fetch_assoc();

    return $res;
}




function create_Student_by_user($conn, $params, $files, $student_id, $email)
{


    $result = array('success' => '', 'error' => '');

    // Extract all fields from the $params array
    $first_name      = $params['first_name'];
    $middle_name     = $params['middle_name'];
    $last_name       = $params['last_name'];
    $date_of_birth   = $params['date_of_birth'];
    $gender          = $params['gender'];
    $email           = $email == NULL ? $params['email'] : $email;
    $guardian_name   = $params['guardian_name'];
    $phone_number = $params['phone_number'];
    $guardian_phone_number = $params['guardian_phone_number'];
    $guardian_relationship = $params['guardian_relationship'];
    $address         = $params['address'];
    $state           = $params['state'];
    $town_village = $params['town_village'];
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
    if (empty($phone_number)) {
        $result['error'] = "phone_number is required.";
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
    if (empty($town_village)) {
        $result['error'] = "Town/Village is required.";
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

    $datetime = date("Y-m-d H:i:s");


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
        // Prepare and execute the student update query
        $dob_mysql = date("Y-m-d", strtotime($date_of_birth));
        $admission_date_mysql = date("Y-m-d", strtotime($admission_date));




        $stmt = $conn->prepare("UPDATE students 
                                    SET first_name = ?, middle_name = ?, last_name = ?, date_of_birth = ?, gender = ?, email = ?, guardian_name = ?, guardian_phone_number = ?, guardian_relationship = ?, address = ?, state = ?, pincode = ?, institute_name = ?, semester = ?, stream = ?, course = ?, admission_date = ?, updated_at = ?, town_village = ? , phone_number = ?, apply_date = ?, student_status = ?, document_id = ?
                                    WHERE id = ?");

        $status = "Pending";
        $stmt->bind_param("ssssssssssssssssssssssii", $first_name, $middle_name, $last_name, $dob_mysql, $gender, $email, $guardian_name, $guardian_phone_number, $guardian_relationship, $address, $state, $pincode, $institute_name, $semester, $stream, $course, $admission_date_mysql, $datetime, $town_village, $phone_number, $datetime, $status, $document_id, $student_id);



        if ($stmt->execute()) {
            $result['success'] = true;
        } else {
            $result['error'] = "Failed to update student record.";
        }
    } else {
        $result['error'] = "Failed to update documents.";
    }

    return $result;
}


function update_Student_by_user($conn, $params, $files, $student_id, $email)
{

    // echo "<pre>";
    // print_r($files);
    // exit;



    $result = array('success' => '', 'error' => '');

    // Extract all fields from the $params array
    $first_name      = $params['first_name'];
    $middle_name     = $params['middle_name'];
    $last_name       = $params['last_name'];
    $date_of_birth   = $params['date_of_birth'];
    $gender          = $params['gender'];
    $email           = $email;
    $guardian_name   = $params['guardian_name'];
    $phone_number = $params['phone_number'];
    $guardian_phone_number = $params['guardian_phone_number'];
    $guardian_relationship = $params['guardian_relationship'];
    $address         = $params['address'];
    $state           = $params['state'];
    $town_village = $params['town_village'];
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
    if (empty($phone_number)) {
        $result['error'] = "phone_number is required.";
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
    if (empty($town_village)) {
        $result['error'] = "Town/Village is required.";
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

    $datetime = date("Y-m-d H:i:s");


    // Handle file uploads conditionally based on whether each file is provided
    $update_photo = !empty($files['photo']['name']);
    $update_id_proof = !empty($files['id_proof']['name']);
    $update_admission_receipt = !empty($files['admission_receipt']['name']);

    // Handle photo upload
    if ($update_photo) {
        $photo_result = handle_file_upload($photo, $allowed_formats, "Photo");
        if (isset($photo_result['error'])) {
            return ['error' => $photo_result['error']];
        }
    }

    // Handle ID proof upload
    if ($update_id_proof) {
        $id_proof_result = handle_file_upload($id_proof, $allowed_formats, "ID Proof");
        if (isset($id_proof_result['error'])) {
            return ['error' => $id_proof_result['error']];
        }
    }

    // Handle admission receipt upload
    if ($update_admission_receipt) {
        $admission_receipt_result = handle_file_upload($admission_receipt, $allowed_formats, "Admission Receipt");
        if (isset($admission_receipt_result['error'])) {
            return ['error' => $admission_receipt_result['error']];
        }
    }

    // Build the SQL query conditionally for file updates
    $sql = "UPDATE documents SET ";
    $params = array();
    $types = "";

    // Append query for each file if it is being updated
    if ($update_photo) {
        $sql .= "photo = ?, photo_type = ?, ";
        $params[] = $photo_result['content'];
        $params[] = $photo['type'];
        $types .= "bs";
    }

    if ($update_id_proof) {
        $sql .= "id_proof = ?, id_proof_type = ?, ";
        $params[] = $id_proof_result['content'];
        $params[] = $id_proof['type'];
        $types .= "bs";
    }

    if ($update_admission_receipt) {
        $sql .= "admission_receipt = ?, admission_receipt_type = ?, ";
        $params[] = $admission_receipt_result['content'];
        $params[] = $admission_receipt['type'];
        $types .= "bs";
    }

    // Complete the query by adding the remaining fields
    $sql .= "updated_at = ? WHERE id = (SELECT document_id FROM students WHERE id = ?)";
    $params[] = $datetime;
    $params[] = $student_id;
    $types .= "si";

    // Prepare and bind the parameters dynamically
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    // Send large data chunks if necessary
    $param_index = 0;
    if ($update_photo) {
        $stmt->send_long_data($param_index++, $photo_result['content']);
    }
    if ($update_id_proof) {
        $stmt->send_long_data($param_index++, $id_proof_result['content']);
    }
    if ($update_admission_receipt) {
        $stmt->send_long_data($param_index++, $admission_receipt_result['content']);
    }
    // Execute the statement
    if ($stmt->execute()) {
        // Prepare and execute the student update query
        $dob_mysql = date("Y-m-d", strtotime($date_of_birth));
        $admission_date_mysql = date("Y-m-d", strtotime($admission_date));




        $stmt = $conn->prepare("UPDATE students 
                                    SET first_name = ?, middle_name = ?, last_name = ?, date_of_birth = ?, gender = ?, email = ?, guardian_name = ?, guardian_phone_number = ?, guardian_relationship = ?, address = ?, state = ?, pincode = ?, institute_name = ?, semester = ?, stream = ?, course = ?, admission_date = ?, updated_at = ?, town_village = ? , phone_number = ?, apply_date = ?
                                    WHERE id = ?");

        $stmt->bind_param("sssssssssssssssssssssi", $first_name, $middle_name, $last_name, $dob_mysql, $gender, $email, $guardian_name, $guardian_phone_number, $guardian_relationship, $address, $state, $pincode, $institute_name, $semester, $stream, $course, $admission_date_mysql, $datetime, $town_village, $phone_number, $datetime, $student_id);


        if ($stmt->execute()) {
            $result['success'] = true;
        } else {
            $result['error'] = "Failed to update student record.";
        }
    } else {
        $result['error'] = "Failed to update documents.";
    }

    return $result;
}


