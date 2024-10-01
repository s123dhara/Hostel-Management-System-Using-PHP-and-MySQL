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
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the `users` table
        $sql = "INSERT INTO users (student_id, email, password, created_at) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $student_id, $email, $hashed_password, $datetime);

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

function create_Student_by_admin_or_user($conn, $params, $files)
{
    $result = array('success' => '', 'error' => '');
    // echo "<pre>";
    // print_r($params);
    // print_r($files);
    // // exit;

    // Extract all fields from the $params array
    $first_name      = $params['first_name'];
    $middle_name     = $params['middle_name'];
    $last_name       = $params['last_name'];
    $date_of_birth   = $params['date_of_birth'];
    $gender          = $params['gender'];
    $email           = $params['email'];
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
        $result['error'] = "town_village is required.";
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
        $current_student_status = "Pending";

        $stmt = $conn->prepare("INSERT INTO students (first_name, middle_name, last_name, date_of_birth, gender, phone_number, email, address, state, town_village, pincode, guardian_name, guardian_phone_number, guardian_relationship, admission_date, institute_name, semester, stream, course, student_status, created_at, apply_date, document_id) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssssssssssssssssssi", $first_name, $middle_name, $last_name, $dob_mysql, $gender, $phone_number, $email, $address, $state, $town_village, $pincode, $guardian_name, $guardian_phone_number, $guardian_relationship, $admission_date_mysql, $institute_name, $semester, $stream, $course, $current_student_status, $datetime, $datetime, $document_id);


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


function getAllStudents($conn, $type = NULL)
{
    // $sql = "SELECT id,first_name, last_name, stream, course, semester FROM students";
    if ($type == NULL) {
        $sql = "SELECT * FROM students WHERE student_status = 'Approved'";
    } else {
        $sql = "SELECT * FROM students WHERE student_status = 'Pending'";
    }
    $result = $conn->query($sql);
    return $result;
}


function update_student_status($conn, $type, $id, $reason = null)
{

    $SQL = "UPDATE students SET student_status = 'Approved' WHERE id = $id";
    $result = $conn->query($SQL);
    return $result;
}


function assign_room_number($conn, $student_id)
{
    $SQL = "SELECT id FROM rooms WHERE room_status = 'Available'";
    $res = $conn->query($SQL);

    if (!$res->num_rows > 0) {
        return array('error' => "NO ROOM IS AVAILABLE");
    }

    $rooms_store_array = array();
    while ($room = $res->fetch_assoc()) {
        array_push($rooms_store_array, $room['id']);
    }

    // Generate a random index from the array
    $random_index = array_rand($rooms_store_array);
    $alloted_room_id = $rooms_store_array[$random_index];

    $SQL = "SELECT current_occupancy, max_occupancy FROM rooms WHERE id = $alloted_room_id";
    $res = $conn->query($SQL);
    $store_result = $res->fetch_assoc();
    $current_occupancy = $store_result['current_occupancy'];
    $max_occupancy = $store_result['max_occupancy'];

    $SQL = "UPDATE rooms SET current_occupancy = $current_occupancy + 1 WHERE 
            id = $alloted_room_id";
    $res = $conn->query($SQL);

    //if max_occupancy achive
    if ($max_occupancy == $current_occupancy + 1) {
        $SQL = "UPDATE rooms SET room_status = 'Occupied' WHERE id = $alloted_room_id";
        $res = $conn->query($SQL);
    }

    //assign Room Id to Student Table 
    $SQL = "UPDATE students SET room_id = $alloted_room_id WHERE id = $student_id";
    $res = $conn->query($SQL);

    return array('success' => "Sucessfully Assigned Room to Students ");
}


function getStudent_approve($conn, $student_id)
{
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT student_status FROM students WHERE id = ?");

    // Bind the student ID parameter
    $stmt->bind_param("i", $student_id);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $res = $stmt->get_result()->fetch_assoc();

    // Check if the student status is 'Approved'
    $student_current_status = $res['student_status'];

    return $student_current_status == 'Approved';
}



function update_Student_by_admin_or_user($conn, $params, $files, $student_id, $email = NULL)
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

    if (isset($_SESSION['user']) && !$_SESSION['user']['isAdmin']) {

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
    } else {

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
    }
    // Execute the statement
    if ($stmt->execute()) {
        $document_id = $stmt->insert_id;
        // Prepare and execute the student update query
        $dob_mysql = date("Y-m-d", strtotime($date_of_birth));
        $admission_date_mysql = date("Y-m-d", strtotime($admission_date));


        if (isset($_SESSION['user']) && !$_SESSION['user']['isAdmin']) {

            $stmt = $conn->prepare("UPDATE students 
                                    SET first_name = ?, middle_name = ?, last_name = ?, date_of_birth = ?, gender = ?, email = ?, guardian_name = ?, guardian_phone_number = ?, guardian_relationship = ?, address = ?, state = ?, pincode = ?, institute_name = ?, semester = ?, stream = ?, course = ?, admission_date = ?, updated_at = ?, town_village = ? , phone_number = ?, apply_date = ?, student_status = ?, document_id = ?
                                    WHERE id = ?");

            $status = "Pending";
            $stmt->bind_param("ssssssssssssssssssssssii", $first_name, $middle_name, $last_name, $dob_mysql, $gender, $email, $guardian_name, $guardian_phone_number, $guardian_relationship, $address, $state, $pincode, $institute_name, $semester, $stream, $course, $admission_date_mysql, $datetime, $town_village, $phone_number, $datetime, $status, $document_id, $student_id);
        } else {
            $stmt = $conn->prepare("UPDATE students 
                                    SET first_name = ?, middle_name = ?, last_name = ?, date_of_birth = ?, gender = ?, email = ?, guardian_name = ?, guardian_phone_number = ?, guardian_relationship = ?, address = ?, state = ?, pincode = ?, institute_name = ?, semester = ?, stream = ?, course = ?, admission_date = ?, updated_at = ?, town_village = ? , phone_number = ?
                                    WHERE id = ?");

            $stmt->bind_param("ssssssssssssssssssssi", $first_name, $middle_name, $last_name, $dob_mysql, $gender, $email, $guardian_name, $guardian_phone_number, $guardian_relationship, $address, $state, $pincode, $institute_name, $semester, $stream, $course, $admission_date_mysql, $datetime, $town_village, $phone_number, $student_id);
        }


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


function checkIsAdmin($conn, $id)
{
    $SQL = "SELECT isAdmin FROM users WHERE student_id = $id";
    $res = $conn->query($SQL);
    $res = $res->fetch_assoc();

    // echo "<pre>";
    // print_r($res);
    // exit;

    // return ($res['isAdmin'] == 0) ? false : true;
    return ($res['isAdmin'] == 0) ? true : false;
}

function deleteStudent($conn, $student_id)
{
    $check_approve_or_not = getStudent_approve($conn, $student_id);

    if ($check_approve_or_not) {
        $SQL = "SELECT room_id FROM students WHERE id = $student_id";
        $res = $conn->query($SQL);
        $res = $res->fetch_assoc();
        $find_room_id = $res['room_id'];

        $SQL = "UPDATE rooms SET current_occupancy = (SELECT current_occupancy FROM rooms WHERE id = $find_room_id) - 1 WHERE id = $find_room_id";
        $res = $conn->query($SQL);
    }

    $SQL = "DELETE FROM documents WHERE id = (SELECT document_id FROM students WHERE id = $student_id)";
    $res = $conn->query($SQL);

    if ($res) {
        $SQL = "DELETE FROM students WHERE id = $student_id";
        $new_res = $conn->query($SQL);

        if ($new_res) {
            return array('success' => "Student Record Successfully Deleted");
        } else {

            return array('error' => "Error " . $conn->error);
        }
    }
}


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
