<?php
// Include your database connection
include('db_connection.php');

// Get filter values from the POST request
$department = isset($_POST['department']) ? $_POST['department'] : '';
$semester = isset($_POST['semester']) ? $_POST['semester'] : '';
$graphType = isset($_POST['graphType']) ? $_POST['graphType'] : 'daily';

// Prepare the SQL query to fetch attendance data based on filters
$query = "SELECT 
                attendance_date, 
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_count
          FROM attendance_mst
          WHERE 1";

// Apply department filter if provided
if ($department) {
    $query .= " AND department = '$department'";
}

// Apply semester filter if provided
if ($semester) {
    $query .= " AND semester = '$semester'";
}

// Apply date range filter based on graphType (daily, weekly, monthly)
if ($graphType == 'weekly') {
    // Group by week
    $query .= " GROUP BY YEARWEEK(attendance_date) ORDER BY attendance_date";
} elseif ($graphType == 'monthly') {
    // Group by month
    $query .= " GROUP BY YEAR(attendance_date), MONTH(attendance_date) ORDER BY attendance_date";
} else {
    // Default is daily
    $query .= " GROUP BY attendance_date ORDER BY attendance_date";
}

// Execute the query
$result = $conn->query($query);

// Initialize arrays to store the data
$labels = [];
$present = [];
$absent = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['attendance_date'];
    $present[] = (int)$row['present_count'];
    $absent[] = (int)$row['absent_count'];
}

// Prepare response data in JSON format
$response = [
    'labels' => $labels,
    'present' => $present,
    'absent' => $absent
];

// Return the response as JSON
echo json_encode($response);
