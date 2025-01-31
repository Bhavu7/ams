<?php
include 'db_connection.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excelFile'])) {
    try {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'attendance_management');
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Get the file
        $file = $_FILES['excelFile']['tmp_name'];
        
        // Validate file
        if (!file_exists($file)) {
            throw new Exception("File not found");
        }

        // Load the Excel file
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Skip header row and process data
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            
            // Validate required fields
            if (empty($row[0]) || empty($row[1])) {
                $errors[] = "Row " . ($i + 1) . ": Missing required fields";
                $errorCount++;
                continue;
            }

            try {
                // Clean and validate data
                $roll_number = trim($row[0]);
                $student_id = intval(trim($row[1])); // Convert to integer
                $name = trim($row[2]);
                $department = trim($row[3]);
                $division = trim($row[4]);
                $semester = trim($row[5]);
                $email = trim($row[6]);
                $phone = trim($row[7]);
                $photo = !empty($row[8]) ? trim($row[8]) : null;

                // Prepare the statement
                $stmt = $conn->prepare("INSERT INTO student_mst (roll_number, student_id, name, department, division, semester, email, phone, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                
                // Note the 'i' for integer student_id
                $stmt->bind_param("sisssssss", 
                    $roll_number,
                    $student_id, // This will now be bound as an integer
                    $name,
                    $department,
                    $division,
                    $semester,
                    $email,
                    $phone,
                    $photo
                );
                
                if (!$stmt->execute()) {
                    throw new Exception("Error inserting row " . ($i + 1) . ": " . $stmt->error);
                }
                
                $successCount++;
                $stmt->close();
                
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
                $errorCount++;
            }
        }

        // Prepare response
        $response = [
            'success' => true,
            'message' => "Processed " . ($successCount + $errorCount) . " rows. " .
                        "Successfully inserted: $successCount. " .
                        "Errors: $errorCount",
            'errors' => $errors
        ];

        // Close the connection
        $conn->close();
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'No file uploaded or invalid request method.'
    ]);
}
?>