<?php
// delete_student.php

include 'db_connection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the roll number from POST request
$roll_number = $_POST['roll_number'] ?? '';

if (empty($roll_number)) {
    echo "error: Roll number is required";
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    // First delete records from attendance_mst table
    $stmt = $conn->prepare("DELETE FROM attendance_mst WHERE roll_number = ?");
    $stmt->bind_param("s", $roll_number);
    $stmt->execute();
    $stmt->close();

    // Then delete the student record
    $stmt = $conn->prepare("DELETE FROM student_mst WHERE roll_number = ?");
    $stmt->bind_param("s", $roll_number);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Commit transaction
        $conn->commit();
        echo "success";
    } else {
        throw new Exception("No student found with the given roll number");
    }
    $stmt->close();

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "error: " . $e->getMessage();
} finally {
    $conn->close();
}
?>