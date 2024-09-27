<?php
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


