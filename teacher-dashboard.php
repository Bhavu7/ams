<?php
include "db_connection.php";

session_start([
    'cookie_httponly' => true,  // Prevent JavaScript access to session cookie
    'cookie_samesite' => 'Strict'  // Prevent CSRF attacks
]);

$teacher = $_SESSION['user'];

if (isset($_POST['submit_attendance'])) {
    $message = "";
    $attendance_date = date("Y-m-d");

    if (isset($_POST['attendance'])) {
        $attendance_data = $_POST['attendance'];

        foreach ($attendance_data as $roll_number => $status) {
            $student_sql = "SELECT roll_number, name, department, division, semester, photo 
                            FROM student_mst 
                            WHERE roll_number = '$roll_number'";
            $student_result = $conn->query($student_sql);

            if ($student_result && $student_result->num_rows > 0) {
                $student = $student_result->fetch_assoc();

                $insert_sql = "INSERT INTO attendance_mst
                               (roll_number, name, department, division, semester, attendance_date, status, photo)
                               VALUES
                               ('" . $student['roll_number'] . "',
                               '" . $student['name'] . "',
                               '" . $student['department'] . "',
                               '" . $student['division'] . "',
                               '" . $student['semester'] . "',
                               '$attendance_date',
                               '$status',
                               '" . $student['photo'] . "')";

                if ($conn->query($insert_sql) === TRUE) {
                    $message .= "Roll Number {$student['roll_number']} recorded as $status.\n";
                } else {
                    $message .= "Error for Roll Number {$student['roll_number']}: " . $conn->error . "\n";
                }
            } else {
                $message .= "No data found for Roll Number $roll_number.\n";
            }
        }
    }
    echo "<script>alert('$message'); window.location = window.location.href;</script>";
}

// Replace ternary operators with null coalescing operator
$status = $data['status'] ?? 'absent';
$report_from_date = $_POST['report_from_date'] ?? '';
$report_to_date = $_POST['report_to_date'] ?? '';

// Initialize result variable
$result = null;

// Use string interpolation for error message
if ($result === false) {
    echo "<tr><td colspan='10' class='px-6 py-4 text-center text-red-500'>Error: {$conn->error}</td></tr>";
}

// $conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Teacher Dashboard - AMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.18/jspdf.plugin.autotable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="\assets\offline\main\tailwind.min.css">
    <script src="\assets\offline\teacher\dashboard\3.4.16"></script>
    <script src="\assets\offline\teacher\dashboard\jquery-3.6.0.min.js"></script>
    <script src="\assets\offline\teacher\dashboard\jspdf.plugin.autotable.min.js"></script>

    <script>
function downloadReport() {
    const departmentDropdown = document.getElementById('departmentFilter');
    const divisionDropdown = document.getElementById('divisionFilter');
    const semesterDropdown = document.getElementById('semesterFilter');

    if (!departmentDropdown.value || !divisionDropdown.value || !semesterDropdown.value) {
        alert('Please ensure all filters (Department, Division, Semester) are selected.');
        return;
    }

    const department = departmentDropdown.value;
    const division = divisionDropdown.value;
    const semester = semesterDropdown.value;

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const table = document.getElementById('attendanceTable');
    const rows = table.querySelectorAll('tr');

    const tableData = [];
    rows.forEach((row, index) => {
        if (index > 0) {
            const cells = row.querySelectorAll('td');
            const markStatusCell = cells[8];
            const presentCheckbox = markStatusCell.querySelector('input[type="checkbox"]');
            const isPresent = presentCheckbox ? presentCheckbox.checked : false;

            const rowData = [
                cells[1].innerText,
                cells[2].innerText,
                cells[3].innerText,
                cells[4].innerText,
                cells[5].innerText,
                cells[6].innerText,
                cells[7].innerText,
                isPresent ? 'Present' : '',
                !isPresent ? 'Absent' : ''
            ];
            tableData.push(rowData);
        }
    });

    // Watermark configuration
    const watermarkText = "DNICA";
    const watermarkOpacity = 0.1;
    const watermarkAngle = -45;

    // Footer configuration
    const footerText = "Generated by Attendance Management System";
    const footerSignature = "Bhavesh Bhoi";

    doc.autoTable({
        head: [['Roll No', 'Student ID', 'Name', 'Department', 'Division', 'Semester', 'Date', 'Present', 'Absent']],
        body: tableData,
        startY: 40, // Make space for header content
        didDrawPage: function(data) {
            // Add watermark to each page
            doc.setTextColor(150);
            doc.setFontSize(40);
            doc.setGState(new doc.GState({ opacity: watermarkOpacity }));
            doc.text(watermarkText, data.settings.margin.left + 40, doc.internal.pageSize.height/2, {
                angle: watermarkAngle
            });
            doc.setGState(new doc.GState({ opacity: 1 }));

            // Add footer to each page
            doc.setFontSize(10);
            doc.setTextColor(100);
            
            // Footer left - Date
            doc.text(`Generated: ${new Date().toLocaleString()}`, 
                data.settings.margin.left, 
                doc.internal.pageSize.height - 10
            );

            // Footer center - Page number
            const pageCount = doc.internal.getNumberOfPages();
            doc.text(`Page ${data.pageNumber} of ${pageCount}`, 
                doc.internal.pageSize.width / 2, 
                doc.internal.pageSize.height - 10,
                { align: 'center' }
            );

            // Footer right - Signature
            doc.text(footerSignature, 
                doc.internal.pageSize.width - data.settings.margin.right, 
                doc.internal.pageSize.height - 10,
                { align: 'right' }
            );
        },
        styles: {
            fontSize: 8,
            cellPadding: 1.5
        },
        headStyles: {
            fillColor: [220, 220, 220],
            textColor: [0, 0, 0],
            fontSize: 8
        },
        bodyStyles: {
            textColor: [0, 0, 0]
        },
        theme: 'grid'
    });

    const filename = `Attendance_Report_${department}_${division}_${semester}_${new Date().toISOString().split('T')[0]}.pdf`;
    doc.save(filename);
}

        function downloadStudentReport() {
            // First check if the table exists
            const table = document.querySelector("#studentReportContainer table");
            if (!table) {
                alert("Please view the report first before downloading");
                return;
            }

            // Get the form values
            const department = document.getElementById('reportDepartmentFilter').value;
            const division = document.getElementById('reportDivisionFilter').value;
            const semester = document.getElementById('reportSemesterFilter').value;
            const rollNumber = document.getElementById('reportRollNumberFilter').value;

            // Create the custom file name
            const fileName = `Attendance_Report_${rollNumber}_${department}_${division}_Sem${semester}.pdf`;

            // Make sure jsPDF is loaded
            if (typeof window.jspdf === 'undefined') {
                // Add jsPDF CDN if not already present
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
                document.head.appendChild(script);

                // Add jsPDF-AutoTable CDN
                const autoTableScript = document.createElement('script');
                autoTableScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js';
                document.head.appendChild(autoTableScript);

                script.onload = () => {
                    autoTableScript.onload = () => {
                        generatePDF(table, fileName);
                    };
                };
            } else {
                generatePDF(table, fileName);
            }
        }

        function generatePDF(table, fileName) {
            // Create new jsPDF instance
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(15);
            doc.text("Student Attendance Report", 14, 10);

            // Add current date
            const currentDate = new Date().toLocaleDateString();
            doc.setFontSize(10);
            doc.text(currentDate, 180, 10, {
                align: 'right'
            });

            // Get table data
            const headers = ["ID", "Roll Number", "Date", "Status"];
            const tableData = [];
            const rows = table.querySelectorAll("tbody tr");

            rows.forEach((row) => {
                const cells = row.querySelectorAll("td");
                const rowData = Array.from(cells).map(cell => cell.textContent.trim());
                tableData.push(rowData);
            });

            // Add table to PDF
            doc.autoTable({
                head: [headers],
                body: tableData,
                startY: 20,
                theme: 'grid',
                styles: {
                    fontSize: 8,
                    cellPadding: 2
                },
                headStyles: {
                    fillColor: [40, 40, 40]
                }
            });

            // Add page numbers
            const pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(8);
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.text(`Page ${i} of ${pageCount}`, 180, doc.internal.pageSize.height - 10, {
                    align: 'right'
                });
            }

            // Add footer
            doc.text('DNICA', 14, doc.internal.pageSize.height - 10);

            // Save the PDF
            doc.save(fileName);
        }

        function logout() {
            // Confirm logout
            if (confirm('Are you sure you want to log out?')) {
                fetch('logout.php', {
                    method: 'POST',
                    credentials: 'same-origin'
                }).then(response => {
                    // Clear any client-side storage if needed
                    localStorage.clear();
                    sessionStorage.clear();

                    // Redirect to login page
                    window.location.href = 'teacher-login.php';
                }).catch(error => {
                    console.error('Logout error:', error);
                    alert('Failed to log out. Please try again.');
                });
            }
        }
    </script>
    <style>
        #dashboard-section,
        #reports-section,
        #attendance-section,
        #profile-section {
            display: none;
        }

        /* Show attendance section by default */
        #attendance-section {
            display: block;
        }

        /* Hide the scrollbar initially */
        #attendanceTableContainer {
            scrollbar-width: thin;
            scrollbar-color: rgb(172, 176, 185) #E5E7EB;
            /* Tailwind gray-500 and gray-200 */
        }

        /* WebKit-based browsers (Chrome, Safari, Edge) */
        #attendanceTableContainer::-webkit-scrollbar {
            width: 8px;
            height: 8px;
            opacity: 0;
            /* Initially hide the scrollbar */
            transition: opacity 0.3s ease;
            /* Smooth transition for opacity */
        }

        #attendanceTableContainer::-webkit-scrollbar-thumb {
            background-color: rgb(219, 219, 219);
            /* Tailwind's gray-500 */
            border-radius: 4px;
        }

        #attendanceTableContainer::-webkit-scrollbar-track {
            background-color: #E5E7EB;
            /* Tailwind's gray-200 */
        }

        /* Show the scrollbar when the container is hovered or scrolled */
        #attendanceTableContainer:hover::-webkit-scrollbar,
        #attendanceTableContainer:active::-webkit-scrollbar {
            opacity: 1;
            /* Show the scrollbar when hovering or scrolling */
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Header and Navigation -->
        <div class="bg-white shadow-lg">
            <!-- Header Section -->
            <header class="bg-gradient-to-r from-green-600 to-green-700 p-4 sticky top-0 z-1">
                <div class="container mx-auto">
                    <h1 class="text-2xl font-bold text-white hover:text-green-100 transition duration-300">
                        Teacher Dashboard
                    </h1>
                </div>
            </header>

            <!-- Nav Links Section -->
            <nav class="bg-white border-b">
                <div class="container mx-auto px-4">
                    <ul class="flex flex-wrap item</div>s-center gap-1 md:gap-4 py-2">
                        <li>
                            <a href="#" onclick="showDashboard()"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg 
                                      hover:bg-green-50 hover:text-green-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Upload Data
                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="toggleStudentReport()"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg 
                                      hover:bg-green-50 hover:text-green-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Reports
                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="showAttendance()"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg 
                                      hover:bg-green-50 hover:text-green-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Attendance
                            </a>
                        </li>
                        </a></a>
                        <li>
                            <a href="#" onclick="showProfile()"
                                class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-lg 
                                      hover:bg-green-50 hover:text-green-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="logout()"
                                class="flex items-center px-3 py-2 text-sm font-medium text-red-600 rounded-lg 
                                      hover:bg-red-50 hover:text-red-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="content">
            <!-- Dashboard Section -->
            <div id="dashboard-section" class="bg-white rounded-lg shadow-lg p-8 max-w-7xl mx-auto mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Upload Excel Data</h2>
                <form id="uploadExcelForm" class="space-y-6" enctype="multipart/form-data">
                    <div class="flex items-center justify-center w-full">
                        <label for="excelFile" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">Excel files only (.xlsx, .xls)</p>
                            </div>
                            <input id="excelFile" name="excelFile" type="file" class="hidden" accept=".xlsx,.xls" required />
                        </label>
                    </div>

                    <div class="flex justify-center">
                        <button type="button" onclick="handleExcelUpload()" class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-300">
                            Upload Excel File
                        </button>
                    </div>

                    <div id="uploadStatus" class="mt-4 text-center"></div>
                </form>
            </div>
        </div>

        <!-- Single Student Report Section -->
        <div class="report-section bg-white rounded-lg shadow-lg p-6 mx-auto max-w-7xl mt-8" id="reports-section">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Student Attendance Reports</h2>

            <div class="bg-gray-50 rounded-lg p-6">
                <form id="studentReportForm" class="space-y-6" method="POST" action="#reports-section">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Department Dropdown -->
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            id="reportDepartmentFilter" name="report_department" required>
                            <option value="">Select Department</option>
                            <option value="FY BCA" <?php echo (isset($_POST['report_department']) && $_POST['report_department'] == 'FY BCA') ? 'selected' : ''; ?>>FY BCA</option>
                            <option value="SY BCA" <?php echo (isset($_POST['report_department']) && $_POST['report_department'] == 'SY BCA') ? 'selected' : ''; ?>>SY BCA</option>
                            <option value="TY BCA" <?php echo (isset($_POST['report_department']) && $_POST['report_department'] == 'TY BCA') ? 'selected' : ''; ?>>TY BCA</option>
                            <option value="FY BSc CA & IT" <?php echo (isset($_POST['report_department']) && $_POST['report_department'] == 'FY BSc CA & IT') ? 'selected' : ''; ?>>FY BSc CA & IT</option>
                            <option value="SY BSc CA & IT" <?php echo (isset($_POST['report_department']) && $_POST['report_department'] == 'SY BSc CA & IT') ? 'selected' : ''; ?>>SY BSc CA & IT</option>
                            <option value="TY BSc CA & IT" <?php echo (isset($_POST['report_department']) && $_POST['report_department'] == 'TY BSc CA & IT') ? 'selected' : ''; ?>>TY BSc CA & IT</option>
                        </select>

                        <!-- Division Dropdown -->
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            id="reportDivisionFilter" name="report_division" required>
                            <option value="">Select Division</option>
                            <option value="Division A" <?php echo (isset($_POST['report_division']) && $_POST['report_division'] == 'Division A') ? 'selected' : ''; ?>>Division A</option>
                            <option value="Division B" <?php echo (isset($_POST['report_division']) && $_POST['report_division'] == 'Division B') ? 'selected' : ''; ?>>Division B</option>
                            <option value="Division C" <?php echo (isset($_POST['report_division']) && $_POST['report_division'] == 'Division C') ? 'selected' : ''; ?>>Division C</option>
                            <option value="Division D" <?php echo (isset($_POST['report_division']) && $_POST['report_division'] == 'Division D') ? 'selected' : ''; ?>>Division D</option>
                        </select>

                        <!-- Semester Dropdown -->
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            id="reportSemesterFilter" name="report_semester" required>
                            <option value="" disabled selected>Select Semester</option>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($_POST['report_semester']) && $_POST['report_semester'] == $i) ? 'selected' : ''; ?>>
                                    Semester <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <!-- Roll Number -->
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Enter Roll No</label>
                            <input type="text"
                                id="reportRollNumberFilter"
                                name="report_roll_number"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Enter Roll Number"
                                value="<?php echo isset($_POST['report_roll_number']) ? htmlspecialchars($_POST['report_roll_number']) : ''; ?>"
                                required>
                        </div>

                        <!-- Date Inputs -->
                        <div class="col-span-full md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-600 mb-1">From Date</label>
                                <input type="date"
                                    id="reportFromDateFilter"
                                    name="report_from_date"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    required
                                    value="<?php echo $_POST['report_from_date'] ?? ''; ?>">
                            </div>

                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-600 mb-1">To Date</label>
                                <input type="date"
                                    id="reportToDateFilter"
                                    name="report_to_date"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    required
                                    value="<?php echo $_POST['report_to_date'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 justify-end">
                        <button type="submit"
                            name="view_student_report"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            View Student Report
                        </button>
                        <button type="button"
                            onclick="downloadStudentReport()"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Download Report
                        </button>
                    </div>
                </form>
            </div>

            <div id="studentReportContainer" class="mt-8">
                <?php
                if (isset($_POST['view_student_report'])) {
                    echo "<script>
            alert('Student Attendance report data displayed successfully!');
            window.location = window.location.href;
        </script>";
                    // Fetch form inputs with updated names
                    $department = $_POST['report_department'] ?? '';
                    $division = $_POST['report_division'] ?? '';
                    $semester = $_POST['report_semester'] ?? '';
                    $roll_number = $_POST['report_roll_number'] ?? '';
                    $from_date = $_POST['report_from_date'] ?? '';
                    $to_date = $_POST['report_to_date'] ?? '';

                    // SQL query to fetch attendance data
                    $query = "
                SELECT id, roll_number, attendance_date, status 
                FROM attendance_mst 
                WHERE roll_number = ? 
                AND department = ? 
                AND division = ? 
                AND semester = ? 
                AND attendance_date BETWEEN ? AND ?
                ORDER BY attendance_date ASC
            ";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ssssss', $roll_number, $department, $division, $semester, $from_date, $to_date);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">';

                        while ($row = $result->fetch_assoc()) {
                            $statusColor = $row['status'] === 'present' ? 'text-green-600' : 'text-red-600';
                            echo "<tr class='hover:bg-gray-50'>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['id']}</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['roll_number']}</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>{$row['attendance_date']}</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm font-medium {$statusColor}'>" . ucfirst($row['status']) . "</td>
                        </tr>";
                        }

                        echo '</tbody></table></div>';
                    } else {
                        echo '<p class="text-gray-500 text-center py-4">No records found for the selected filters.</p>';
                    }

                    $stmt->close();
                }
                ?>
            </div>
        </div>

        <!-- Student Attendance Section -->
        <div class="attendance-section bg-white rounded-lg shadow-lg p-6 mx-auto max-w-7xl mt-8 mb-8" id="attendance-section">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Manage Students Attendance</h2>

            <!-- Filters Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <form id="attendanceFilterForm" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Department Dropdown -->
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            id="departmentFilter" name="department" required>
                            <option value="">Select Department</option>
                            <option value="FY BCA" <?php if (isset($_POST['department']) && $_POST['department'] == 'FY BCA') echo 'selected'; ?>>FY BCA</option>
                            <option value="SY BCA" <?php if (isset($_POST['department']) && $_POST['department'] == 'SY BCA') echo 'selected'; ?>>SY BCA</option>
                            <option value="TY BCA" <?php if (isset($_POST['department']) && $_POST['department'] == 'TY BCA') echo 'selected'; ?>>TY BCA</option>
                            <option value="FY BSc CA & IT" <?php if (isset($_POST['department']) && $_POST['department'] == 'FY BSc CA & IT') echo 'selected'; ?>>FY BSc CA & IT</option>
                            <option value="SY BSc CA & IT" <?php if (isset($_POST['department']) && $_POST['department'] == 'SY BSc CA & IT') echo 'selected'; ?>>SY BSc CA & IT</option>
                            <option value="TY BSc CA & IT" <?php if (isset($_POST['department']) && $_POST['department'] == 'TY BSc CA & IT') echo 'selected'; ?>>TY BSc CA & IT</option>
                        </select>

                        <!-- Division Dropdown -->
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            id="divisionFilter" name="division" required>
                            <option value="">Select Division</option>
                            <option value="Division A" <?php if (isset($_POST['division']) && $_POST['division'] == 'Division A') echo 'selected'; ?>>Division A</option>
                            <option value="Division B" <?php if (isset($_POST['division']) && $_POST['division'] == 'Division B') echo 'selected'; ?>>Division B</option>
                            <option value="Division C" <?php if (isset($_POST['division']) && $_POST['division'] == 'Division C') echo 'selected'; ?>>Division C</option>
                            <option value="Division D" <?php if (isset($_POST['division']) && $_POST['division'] == 'Division D') echo 'selected'; ?>>Division D</option>
                        </select>

                        <!-- Semester Dropdown -->
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            id="semesterFilter" name="semester" required>
                            <option value="" disabled selected>Select Semester</option>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php if (isset($_POST['semester']) && $_POST['semester'] == $i) echo 'selected'; ?>>
                                    Semester <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4 justify-end">
                        <button type="submit" name="view_student_records"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            View Student Records
                        </button>
                        <button type="submit" name="edit_attendance"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            Edit Attendance
                        </button>
                        <!-- <button type="submit" name="exportExcel"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            Export Excel
                        </button> -->
                        <button type="button" onclick="downloadReport()"
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                            Download Report
                        </button>
                    </div>
                </form>
            </div>


            <!-- Attendance Form -->
            <form action="" method="POST">
                <div id="attendanceTableContainer" class="overflow-x-auto overflow-y-auto max-h-[70vh] transition-all duration-300"
                    style="display: <?php echo isset($_POST['department']) && isset($_POST['division']) && isset($_POST['semester']) ? 'block' : 'none'; ?>;">
                    <table id="attendanceTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Division</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mark Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            if (isset($_POST['department']) && isset($_POST['division']) && isset($_POST['semester'])) {
                                $department = $_POST['department'];
                                $division = $_POST['division'];
                                $semester = $_POST['semester'];

                                $sql = "SELECT * FROM student_mst WHERE department = '$department' AND division = '$division' AND semester = '$semester'";
                                $result = $conn->query($sql);

                                if ($result === false) {
                                    echo "<tr><td colspan='9' class='px-6 py-4 text-center text-red-500'>Error: {$conn->error}</td></tr>";
                                } else if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr class='hover:bg-gray-50'>
                                    <td class='px-6 py-4 whitespace-nowrap'><img src='uploads/" . $row['photo'] . "' alt='Student Photo' class='h-10 w-10 rounded-full'></td>
                                    <td class='px-6 py-4 whitespace-nowrap'>" . $row['roll_number'] . "</td>
                                    <td class='px-6 py-4 whitespace-nowrap'>" . $row['student_id'] . "</td>
                                    <td class='px-6 py-4 whitespace-nowrap'>" . $row['name'] . "</td>
                                    <td class='px-6 py-4 whitespace-nowrap'>" . $row['department'] . "</td>
                                    <td class='px-6 py-4 whitespace-nowrap'>" . $row['division'] . "</td>
                                    <td class='px-6 py-4 whitespace-nowrap'>" . $row['semester'] . "</td>
                                    <td class='px-6 py-4 whitespace-nowrap'>" . date("Y-m-d") . "</td>
                                    <td class='px-6 py-4 whitespace-nowrap'>
                                        <input type='hidden' name='attendance[" . $row['roll_number'] . "]' value='absent'>
                                        <input type='checkbox' name='attendance[" . $row['roll_number'] . "]' value='present' class='h-4 w-4 text-green-600' checked>
                                    </td>
                                </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='px-6 py-4 text-center text-gray-500'>No students found</td></tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($_POST['department']) && isset($_POST['division']) && isset($_POST['semester'])): ?>
                    <div class="mt-3 text-right">
                        <button type="submit" name="submit_attendance"
                            class="px-8 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            Submit Attendance
                        </button>
                    </div>
                <?php endif; ?>
            </form>

            <?php
            // PHP logic remains unchanged
            if (isset($_POST['view_student_records'])) {
                echo "<script>
                        alert('Attendance records displayed successfully!');
                        // window.location = window.location.href;
                    </script>";
            }

            if (isset($_POST['submit_attendance'])) {
                echo "<script>
                        alert('Attendance submitted successfully!');
                        window.location = window.location.href;
                    </script>";
            }
            ?>
        </div>

        <!-- Profile Section -->
        <div class="profile-section bg-white rounded-lg shadow-lg p-6 mx-auto max-w-7xl mt-8" id="profile-section">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Teacher Profile</h2>

            <form id="profileForm" method="post" enctype="multipart/form-data">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Profile Image Section -->
                    <div class="md:col-span-1">
                        <div class="flex flex-col items-center">
                            <div class="relative">
                                <img src="<?php echo $teacher['profile_photo'] ?>"
                                    alt="Teacher Profile"
                                    class="h-48 w-48 rounded-full object-cover border-4 border-green-500">
                                <!-- <label for="profile-image-input"
                                    class="absolute bottom-0 right-0 bg-green-500 text-white p-2 rounded-full cursor-pointer hover:bg-green-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label> -->
                            </div>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="md:col-span-2">
                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b">Personal Information</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Teacher ID</label>
                                    <input type="text" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Full Name</label>
                                    <input type="text" name="fullName" value="<?php echo $teacher['name']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Email</label>
                                    <input type="email" name="email" value="<?php echo $teacher['email']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Phone</label>
                                    <input type="tel" name="phone" value="<?php echo $teacher['phone']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Date of Birth</label>
                                    <input type="date" name="dob" value="<?php echo $teacher['dob']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Address</label>
                                    <input type="text" name="address" value="<?php echo $teacher['address']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b">Professional Information</h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Department</label>
                                    <input type="text" name="department" value="<?php echo $teacher['department']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Specialization</label>
                                    <input type="text" name="specialization" value="<?php echo $teacher['specialization']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Qualification</label>
                                    <input type="text" name="qualification" value="<?php echo $teacher['qualification']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-600">Experience</label>
                                    <input type="text" name="experience" value="<?php echo $teacher['experience']; ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>
    <script>
        function handleExcelUpload() {
            const fileInput = document.getElementById('excelFile');
            const uploadStatus = document.getElementById('uploadStatus');

            if (!fileInput.files.length) {
                uploadStatus.innerHTML = '<div class="text-red-600">Please select a file first.</div>';
                return;
            }

            const formData = new FormData();
            formData.append('excelFile', fileInput.files[0]);

            // Display loading status
            uploadStatus.innerHTML = '<div class="text-blue-600">Uploading and processing data...</div>';

            fetch('upload_excel.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        uploadStatus.innerHTML = `
                <div class="text-green-600">${data.message}</div>
                ${data.errors.length > 0 ? 
                    `<div class="mt-4 text-red-600">
                        <strong>Errors:</strong>
                        <ul class="list-disc pl-5">
                            ${data.errors.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    </div>` 
                    : ''
                }`;

                        // Clear the file input after successful upload
                        fileInput.value = '';
                    } else {
                        uploadStatus.innerHTML = `<div class="text-red-600">Error: ${data.message}</div>`;
                    }
                })
                .catch(error => {
                    uploadStatus.innerHTML = `<div class="text-red-600">Error: ${error.message}</div>`;
                });
        }
    </script>
    <?php
    $conn->close();
    ?>
</body>
<script src="assets/Js/teacherDashboard.js">
    //export Excel data
    document.getElementById('exportExcel').addEventListener('click', function() {
        // Get values dynamically if needed (optional)
        const department = document.getElementById('department').value;
        const division = document.getElementById('division').value;
        const semester = document.getElementById('semester').value;

        // Perform validations if needed
        if (!department || !division || !semester) {
            alert('Please select all filter options before exporting.');
            return;
        }

        // Submit the form
        document.getElementById('exportForm').submit();
    });


    document.getElementById("attendanceTab").addEventListener("click", function() {
        document.getElementById("attendanceSection").style.display = "block";
        document.getElementById("otherSection").style.display = "none";
    });

    $(document).ready(function() {
        $("form").submit(function(event) {
            event.preventDefault(); // Prevent page refresh on form submission
            $.ajax({
                url: "", // Send request to the same page
                method: "POST",
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    // Show success message or update the page content
                    alert("Attendance Submitted Successfully!");
                },
                error: function() {
                    alert("There was an error while submitting the form.");
                }
            });
        });
    });

    function logout() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "?logout=true", true); // Leave the URL blank to call the current PHP file
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Redirect to login page after logging out
                window.location.href = "index.php"; // Redirect to login or another page
            }
        };
        xhr.send();
    }
</script>

</html>