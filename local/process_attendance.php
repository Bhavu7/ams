<!-- process_attendance.php -->
<?php
include 'db_connection.php';
header('Content-Type: application/json');

// Database connection
$response = ['success' => false, 'message' => ''];

try {
    // Prepare the attendance insertion statement
    $insert_stmt = $conn->prepare("INSERT INTO attendance_log (student_id, roll_number, attendance_date, status) VALUES (?, ?, ?, ?)");
    
    if (isset($_POST['attendance']) && is_array($_POST['attendance'])) {
        $attendance_date = date('Y-m-d');
        $success_count = 0;
        $error_count = 0;

        foreach ($_POST['attendance'] as $roll_number => $attendance_data) {
            // Fetch student details
            $student_stmt = $conn->prepare("SELECT student_id FROM student_mst WHERE roll_number = ?");
            $student_stmt->bind_param("s", $roll_number);
            $student_stmt->execute();
            $student_result = $student_stmt->get_result();
            
            if ($student_result->num_rows > 0) {
                $student = $student_result->fetch_assoc();
                $student_id = $student['student_id'];
                $status = $attendance_data['status'] ?? '';

                // Only insert if a status is selected
                if (!empty($status)) {
                    $insert_stmt->bind_param("ssss", $student_id, $roll_number, $attendance_date, $status);
                    
                    if ($insert_stmt->execute()) {
                        $success_count++;
                    } else {
                        $error_count++;
                    }
                }
            }
        }

        // Prepare response
        $response['success'] = $error_count === 0;
        $response['message'] = "Processed $success_count records. Errors: $error_count";
    } else {
        $response['message'] = "No attendance data received";
    }
} catch (Exception $e) {
    $response['message'] = "Error: " . $e->getMessage();
}

// Output JSON response
echo json_encode($response);
?>