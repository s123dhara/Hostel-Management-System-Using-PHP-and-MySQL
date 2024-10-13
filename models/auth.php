<?php

function login($conn, $params)
{

    extract($params);
    $sql = "select * from users where email = '$email'";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        $user = mysqli_fetch_assoc($res);
        $hash = $user['password'];

        if (password_verify($password, $hash)) {
            $result = array('status' => true, 'user' => $user);
        } else {
            $result = array('status' => false);
        }
    } else {
        $result = array('status' => false);
    }
    return $result;
}
// Function to update profile
function updateProfile($conn, $param, $student_id, $files)
{
    // Extract specific parameters from $param instead of using extract()
    $email = isset($param['email']) ? $param['email'] : null;
    $phone_no = isset($param['phone_no']) ? $param['phone_no'] : null;
    $username = isset($param['username']) ? $param['username'] : null;

    $allowed_formats = ['image/png', 'image/jpeg', 'image/jpg'];
    $user_id = intval($_SESSION['user']['id']);
    $datetime = date("Y-m-d H:i:s");

    $update_profile_pic = !empty($files['profile_pic']['name']);
    $params = array();
    $types = "";

    // Start building SQL query for updating users
    $SQL = "UPDATE users SET ";

    if ($email) {
        $SQL .= "email = ?, ";
        $params[] = $email;
        $types .= "s";


        //change email in student table
        $student_id = intval($student_id);
        $student_sql = "UPDATE students SET email = ? WHERE id = ?";
        $stmt_student = $conn->prepare($student_sql);
        $stmt_student->bind_param("si", $email, $student_id);

        $stmt_student->execute();

    }

    if ($username) {
        $SQL .= "username = ?, ";
        $params[] = $username;
        $types .= "s";
    }

    // Handle profile picture upload
    if ($update_profile_pic) {
        $profile_pic = $files['profile_pic'];
        $profile_pic_result = handle_file_upload($profile_pic, $allowed_formats, "profile_pic");
        if (isset($profile_pic_result['error'])) {
            return ['error' => $profile_pic_result['error']];
        }
        $SQL .= "profile_pic = ?, profile_pic_type = ?, ";
        $params[] = $profile_pic_result['content'];
        $params[] = $profile_pic['type'];
        $types .= "bs";
    }

    // Complete the query by adding the updated_at and user id conditions
    $SQL .= "updated_at = ? WHERE id = ?";
    $params[] = $datetime;
    $params[] = $user_id;
    $types .= "si";

    // Prepare and bind the parameters dynamically
    $stmt = $conn->prepare($SQL);
    if ($stmt === false) {
        return ['error' => 'Error preparing the SQL statement: ' . $conn->error];
    }

    $stmt->bind_param($types, ...$params);

    // Send long data for profile_pic if it's being updated
    if ($update_profile_pic) {
        $stmt->send_long_data(2, $profile_pic_result['content']);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Update the student's phone number if provided        
        if ($email) {
            $_SESSION['user']['email'] = $email;
        }
        if ($username) {
            $_SESSION['user']['username'] = $username;
        }

        if($update_profile_pic) {
            $_SESSION['user']['profile_pic'] = $profile_pic_result['content'];
            $_SESSION['user']['profile_pic_type'] = $profile_pic['type'];
        }

        if ($phone_no) {
            $SQL_student = "UPDATE students SET phone_number = ? WHERE id = ?";
            $stmt_student = $conn->prepare($SQL_student);
            if ($stmt_student === false) {
                return ['error' => 'Error preparing the SQL statement for students: ' . $conn->error];
            }
            $stmt_student->bind_param("si", $phone_no, $student_id);

            if ($stmt_student->execute()) {
                return ['success' => "User details have been updated successfully"];
            } else {
                return ['error' => 'Error updating the student\'s phone number: ' . $stmt_student->error];
            }
        }

        return ['success' => "User details have been updated successfully"];
    } else {
        return ['error' => 'Error executing the update query: ' . $stmt->error];
    }
}
