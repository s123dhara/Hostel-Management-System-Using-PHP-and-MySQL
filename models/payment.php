<?php

function updatePayment($conn, $student_id, $params, $plan_id)
{
    // Extract parameters from array
    extract($params);

    // Insert into transactions table
    $SQL = "INSERT INTO transactions(name, email, phone_number)
            VALUES(?, ?, ?)";
    $stmt = $conn->prepare($SQL);
    if (!$stmt) {
        return array('error' => 'Failed to prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $phone_number);

    if ($stmt->execute()) {
        // Get the last inserted transaction ID
        $transaction_id = $stmt->insert_id;
        // Format the date to match MySQL's DATETIME format
        $datetime = date("Y-m-d H:i:s");

        // Insert into payments table
        $SQL = "INSERT INTO payments(student_id, transaction_id, payment_date, plan_id)
                VALUES(?,?,?,?)";
        $stmt = $conn->prepare($SQL);
        if (!$stmt) {
            return array('error' => 'Failed to prepare statement: ' . $conn->error);
        }

        $stmt->bind_param("iiss", $student_id, $transaction_id, $datetime, $plan_id);

        if ($stmt->execute()) {
            // Close the statement
            $stmt->close();
            return array('success' => 'Payment Done!');
        } else {
            return array('error' => 'Failed to update payment details: ' . $stmt->error);
        }
    } else {
        return array('error' => 'Failed to update payment details in transactions: ' . $stmt->error);
    }
}
