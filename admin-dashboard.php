<?php
session_start();
include("db_connection.php");

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");  // Redirect to login page if not logged in
  exit();
}

$message = "";

// Insert Teacher information into database
if (isset($_POST['add_teacher'])) {
  // Check if a file is uploaded
  if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $profilePhoto = $_FILES['profile_photo']['name'];
    $target_dir = "uploads/teachers/";
    $target_file = $target_dir . basename($profilePhoto);

    // Move uploaded file
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
      $profilePhoto = basename($profilePhoto); // Store only the file name
    } else {
      $message = "Failed to upload profile photo.";
      $profilePhoto = ""; // Default to empty if upload fails
    }
  } else {
    $profilePhoto = ""; // Handle no file upload
  }

  $name = $_POST['name'];
  $dob = $_POST['dob'];
  $doj = $_POST['doj'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $department = $_POST['department'];
  $qualification = $_POST['qualification'];
  $experience = $_POST['experience'];
  $specialization = $_POST['specialization'];

  // Insert into teacher_mst table
  $sql = "INSERT INTO teacher_mst (profile_photo, name, dob, doj, email, password, phone, address, department, qualification, experience, specialization)
          VALUES ('$profilePhoto', '$name', '$dob', '$doj', '$email', '$password', '$phone', '$address', '$department', '$qualification', '$experience', '$specialization')";

  if ($conn->query($sql) === TRUE) {
    $message = "Teacher added successfully!";
  } else {
    $message = "Error: " . $conn->error;
  }
  echo "<script>alert('$message');</script>";
}


// Insert Student
if (isset($_POST['add_student'])) {
  $studentID = $_POST['student_id'];
  $name = $_POST['name'];
  $department = $_POST['department'];
  $division = $_POST['division'];
  $semester = $_POST['semester'];
  $rollNumber = $_POST['roll_number'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $photo = $_FILES['photo']['name'];

  // Move uploaded photo to the "uploads" directory
  $target_dir = "uploads/students/";
  $target_file = $target_dir . basename($photo);
  move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

  // Insert into student_mst table
  $sql = "INSERT INTO student_mst (student_id, name, department, division, semester, roll_number, email, phone, photo)
            VALUES ('$studentID', '$name', '$department', '$division', '$semester', '$rollNumber', '$email', '$phone', '$photo')";

  if ($conn->query($sql) === TRUE) {
    $message = "Student added successfully!";
  } else {
    $message = "Error: " . $conn->error;
  }
}

// Update Student Form  (Update Student)
// Check if the form is submitted
if (isset($_POST['update_student'])) {
  // Retrieve form data
  $student_id = $_POST['student_id'];
  $name = $_POST['name'];
  $department = $_POST['department'];
  $division = $_POST['division'];
  $semester = $_POST['semester'];
  $roll_number = $_POST['roll_number'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $photo = $_FILES['photo']['name'];

  // Check if photo is uploaded
  if ($photo) {
    // Handle file upload
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_path = 'uploads/students/' . $photo;
    move_uploaded_file($photo_tmp, $photo_path);
  }

  // SQL query to update student details
  $sql = "UPDATE student_mst SET 
              student_id = ?, 
              name = ?, 
              department = ?, 
              division = ?, 
              semester = ?, 
              email = ?, 
              phone = ?, 
              photo = ?
          WHERE roll_number = ?";

  // Prepare statement
  if ($stmt = $conn->prepare($sql)) {
    // Bind parameters
    $stmt->bind_param('sssssssss', $student_id, $name, $department, $division, $semester, $email, $phone, $photo, $roll_number);

    // Execute the query
    if ($stmt->execute()) {
      echo "<script>alert('Student details updated successfully!');</script>";
    } else {
      echo "<script>alert('Error updating student details: " . $stmt->error . "');</script>";
    }
    // Close the statement
    $stmt->close();
  } else {
    // Error message in alert if prepare fails
    echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
  }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_profile'])) {
  // Retrieve the data from the form
  $full_name = $_POST['full_name'];
  $dob = $_POST['dob'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $role = $_POST['role'];
  $department = $_POST['department'];
  $doj = $_POST['doj'];
  $status = $_POST['status'];

  // Initialize the image update string as an empty string
  $imageUpdate = '';

  // Handle profile image upload
  if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name']) {
    $profile_image = $_FILES['profile_image']['name'];
    // Set the target directory for image upload
    $target_dir = "uploads/admin/";
    $target_file = $target_dir . basename($profile_image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is a valid image type
    $check = getimagesize($_FILES['profile_image']['tmp_name']);
    if ($check === false) {
      $imageError = "File is not an image.";
    } else {
      // Move the uploaded file to the target directory
      if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
        // If image uploaded successfully, set the image update variable
        $imageUpdate = ", profile_image = '" . basename($profile_image) . "'";
      } else {
        $imageError = "Sorry, there was an error uploading your file.";
      }
    }
  }

  // SQL query to update admin profile for admin with id 1
  $admin_id = 1; // Specifically update the admin with ID 1
  $sql = "UPDATE admin_mst SET
          full_name = ?, dob = ?, email = ?, phone = ?, address = ?, role = ?, department = ?, doj = ?, status = ? 
          $imageUpdate
          WHERE admin_id = ?";

  // Prepare and execute the statement
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssssssssi", $full_name, $dob, $email, $phone, $address, $role, $department, $doj, $status, $admin_id);
    $stmt->execute();

    // Check for successful update
    if ($stmt->affected_rows > 0) {
      $message = "Profile updated successfully!";
    } else {
      $message = "No changes made or error occurred.";
    }

    $stmt->close();
  }
}

// Fetch the updated admin data to display in read-only mode
$admin_id = 1; // Fetch data for admin with ID 1
$sql = "SELECT * FROM admin_mst WHERE admin_id = ?";
if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("i", $admin_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $admin_data = $result->fetch_assoc();
  $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - AMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.27/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/CSS/adminDashboard.css">
  <script>
    // Define the deleteStudent function
    function deleteStudent(rollNumber) {
      // Validate exact roll number format: 2 digits + BIT/BCA + 3 digits
      // Example: 22BIT008 or 22BCA008
      const rollNumberPattern = /^\d{2}(BIT|BCA)\d{3}$/;

      if (!rollNumberPattern.test(rollNumber)) {
        alert("Invalid roll number format. Format should be like '22BIT008' or '22BCA008'");
        return;
      }

      if (confirm("Are you sure you want to delete this student?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_student.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Send the roll number to PHP to delete the record
        xhr.send("roll_number=" + encodeURIComponent(rollNumber));

        // Handle the response
        xhr.onload = function() {
          if (xhr.status == 200) {
            var response = xhr.responseText;
            if (response === "success") {
              // Find and remove the student row
              var row = document.getElementById('student-row-' + rollNumber);
              if (row) {
                row.parentNode.removeChild(row);
                // Show success message with formatted roll number
                alert("Student with roll number " + rollNumber + " has been deleted successfully.");
              } else {
                alert("Row element not found in the DOM.");
              }
            } else {
              alert("Error: Unable to delete student. Server response: " + response);
            }
          } else {
            alert("Error with the request. Status: " + xhr.status);
          }
        };

        // Add error handling for network issues
        xhr.onerror = function() {
          alert("Network error occurred while trying to delete the student.");
        };
      }
    }

    function deleteTeacher(teacherId) {
      // Confirm deletion
      if (confirm("Are you sure you want to delete this teacher?")) {
        // Create an XMLHttpRequest to send the data to the current PHP page
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true); // Send POST request to the current page
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Send the teacher_id to the PHP script (current page)
        xhr.send("action=delete_teacher&teacher_id=" + teacherId);

        // Handle the response after the request
        xhr.onload = function() {
          if (xhr.status == 200) {
            // If the deletion is successful, remove the row from the table
            var row = document.querySelector(`button[onclick='deleteTeacher(${teacherId})']`).closest("tr");
            row.remove(); // Remove the row from the DOM
          } else {
            alert("Error: Could not delete teacher.");
          }
        };
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      function generateReport() {
        const table = document.getElementById('attendanceTable');
        const departmentDropdown = document.querySelector('.departmentDropdown');
        const divisionDropdown = document.querySelector('.divisionDropdown');
        const semesterDropdown = document.querySelector('.semesterDropdown');
        const startDateInput = document.querySelector('.startDateInput'); // Assuming you have an input for start date
        const endDateInput = document.querySelector('.endDateInput'); // Assuming you have an input for end date

        // Extract values from the dropdowns and inputs
        const department = departmentDropdown ? departmentDropdown.value : 'UnknownDepartment';
        const division = divisionDropdown ? divisionDropdown.value : 'UnknownDivision';
        const semester = semesterDropdown ? semesterDropdown.value : 'UnknownSemester';

        // Ensure start and end dates have values, else set default empty string
        const startDate = startDateInput && startDateInput.value ? new Date(startDateInput.value) : '';
        const endDate = endDateInput && endDateInput.value ? new Date(endDateInput.value) : '';

        // Format dates if they exist, else leave empty
        const startDatePart = startDate ? startDate.toISOString().split('T')[0] : 'UnknownStartDate';
        const endDatePart = endDate ? endDate.toISOString().split('T')[0] : 'UnknownEndDate';

        // Get the current date in ISO format (YYYY-MM-DD)
        const currentDate = new Date();
        const datePart = currentDate.toISOString().split('T')[0]; // Extract the current date

        // Filename Construction with Department, Division, Semester, Date Range and Current Date
        const filename = `Attendance_Report_${department}_${division}_${semester}_${startDatePart}_${endDatePart}_${datePart}.pdf`;

        const {
          jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        // Add Watermark at the top-left
        doc.setTextColor(150); // Set watermark color (light gray)
        doc.setFontSize(15); // Set the size for the watermark text
        doc.text("i-Tech Ltd.", 20, 20, {
          align: 'left',
          opacity: 0.1
        }); // Add watermark with opacity

        // Add the current date and time at the top-right
        const formattedDate = currentDate.toLocaleString(); // Format date and time
        doc.setFontSize(8); // Set the font size for the date
        doc.setTextColor(0); // Set text color for the date to black
        doc.text(formattedDate, 180, 20, {
          align: 'right'
        }); // Position date at top-right

        // Add the table to the PDF
        doc.autoTable({
          html: table,
          startY: 40,
          headStyles: {
            fontSize: 7, // Font size for table headers (<th>)
            fontStyle: 'bold', // Make headers bold
            halign: 'center', // Align headers to center
            valign: 'middle', // Align text vertically in headers
          },
          bodyStyles: {
            fontSize: 6, // Font size for table data cells (<td>)
            halign: 'center', // Align data cells to center
            valign: 'middle', // Align text vertically in data cells
          },
        });

        // Add page number to the footer
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
          doc.setPage(i); // Switch to each page in the document
          doc.setFontSize(10);
          doc.text(`Page ${i} of ${pageCount}`, 10, doc.internal.pageSize.height - 10, {
            align: 'left'
          });
          doc.text("Bhavesh Bhoi", doc.internal.pageSize.width - 20, doc.internal.pageSize.height - 10, {
            align: 'right'
          });
        }

        // Save the PDF with the dynamic filename
        doc.save(filename); // Use the constructed filename
      }

      // Attach the event listener to the button
      document.getElementById('generateReportBtn').addEventListener('click', generateReport);
    });

    // admin logout
    function logoutAdmin() {
    // Show a confirmation dialog before logging out
    const confirmation = confirm("Are you sure you want to log out?");
    
    if (confirmation) {
      // Create an AJAX request to logout.php if the user confirms
      fetch('logout_admin.php', {
        method: 'POST',  // Use POST request method
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',  // Setting the content type for the request
        },
        body: 'logout=true'  // Send a flag to indicate that the user wants to log out
      })
      .then(response => response.text())  // Process the server response
      .then(data => {
        console.log('Server Response:', data);  // Log the response for debugging
        
        if (data === 'success') {
          // If logout is successful, redirect the user to the login page
          window.location.href = 'admin-login.php';  // Redirect to login page after successful logout
        } else {
          alert('Error logging out. Please try again.');  // Show error message if something goes wrong
        }
      })
      .catch(error => {
        console.error('Error:', error);  // Log any error for debugging
        alert('An error occurred while logging out.');
      });
    } else {
      // If the user cancels, simply do nothing and return
      return;
    }
  }
  </script>
</head>

<body>
  <div class="min-h-screen bg-gray-100">
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg sticky top-0 z-50">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <a href="#" class="flex items-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white hover:text-blue-100 transition duration-300">
              Admin Dashboard
            </h1>
          </a>

          <!-- Desktop Navigation -->
          <nav class="hidden bg-transparent md:flex md:items-center md:space-x-6">
            <a href="#" onclick="showGraph()" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">
              Graph
            </a>
            <a href="#" onclick="showTeachers()" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">
              Teachers
            </a>
            <a href="#" onclick="showStudents()" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">
              Students
            </a>
            <a href="#" onclick="showAttendance()" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">
              View Attendance
            </a>
            <a href="#" onclick="showProfile()" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">
              Profile
            </a>
            <a href="#" onclick="logoutAdmin()" class="text-red-300 hover:text-red-400 px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">
              Log Out
            </a>
          </nav>

          <!-- Mobile Menu Button -->
          <div class="flex md:hidden">
            <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
              <span class="sr-only">Open main menu</span>
              <!-- Mobile menu icon -->
              <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <a href="#" onclick="showGraph()" class="block text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">
            Graph
          </a>
          <a href="#" onclick="showTeachers()" class="block text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">
            Teachers
          </a>
          <a href="#" onclick="showStudents()" class="block text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">
            Students
          </a>
          <a href="#" onclick="showAttendance()" class="block text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">
            View Attendance
          </a>
          <a href="#" onclick="showProfile()" class="block text-gray-200 hover:bg-blue-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">
            Profile
          </a>
          <a href="#" onclick="logoutAdmin()" class="block text-red-300 hover:bg-red-50 px-3 py-2 rounded-md text-base font-medium">
            Log Out
          </a>
        </div>
      </div>
    </header>

    <script>
      // Mobile menu toggle
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');

      mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    </script>

    <!-- Attendance Data Section -->
    <div id="graph-section" class="bg-white p-6 rounded-lg shadow-lg mx-4 mt-8 mb-10 md:mx-auto max-w-7xl">
      <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 md:mb-0">Attendance Analytics</h2>
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
          <select id="graphType" class="rounded-md border border-blue-500 px-3 py-2">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
          </select>
          <select id="departmentFilter" class="rounded-md border border-blue-500 px-3 py-2">
            <option value="">All Departments</option>
            <option value="FY BCA">FY BCA</option>
            <option value="SY BCA">SY BCA</option>
            <option value="TY BCA">TY BCA</option>
            <option value="FY BSc CA & IT">FY BSc CA & IT</option>
            <option value="SY BSc CA & IT">SY BSc CA & IT</option>
            <option value="TY BSc CA & IT">TY BSc CA & IT</option>
          </select>
          <select id="semesterFilter" class="rounded-md border border-blue-500 px-3 py-2">
            <option value="">All Semesters</option>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
            <option value="3">Semester 3</option>
            <option value="4">Semester 4</option>
            <option value="5">Semester 5</option>
            <option value="6">Semester 6</option>
            <option value="7">Semester 7</option>
            <option value="8">Semester 8</option>
          </select>
        </div>
      </div>

      <!-- Graph Container -->
      <div class="w-full h-64 sm:h-80 md:h-96">
        <canvas id="attendanceChart"></canvas>
      </div>

      <script>
        // Initialize chart
        let myChart;
        const ctx = document.getElementById('attendanceChart').getContext('2d');

        // Fetch and update chart data
        function updateGraph() {
          const graphType = document.getElementById('graphType').value;
          const department = document.getElementById('departmentFilter').value;
          const semester = document.getElementById('semesterFilter').value;

          // Prepare form data
          const formData = new FormData();
          formData.append('graphType', graphType);
          formData.append('department', department);
          formData.append('semester', semester);

          // Fetch data using axios or fetch
          axios.post('fetch_attendance_data.php', formData)
            .then(response => {
              const data = response.data;

              // Prepare chart data
              const chartData = {
                labels: data.labels,
                datasets: [{
                    label: 'Present',
                    data: data.present,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Absent',
                    data: data.absent,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                  }
                ]
              };

              // If the chart already exists, destroy it and create a new one
              if (myChart) {
                myChart.destroy();
              }

              // Create new chart
              myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  scales: {
                    y: {
                      beginAtZero: true,
                      max: 100,
                      title: {
                        display: true,
                        text: 'Attendance Percentage'
                      }
                    }
                  },
                  plugins: {
                    title: {
                      display: true,
                      text: 'Student Attendance Overview'
                    }
                  }
                }
              });
            })
            .catch(error => {
              console.error('Error fetching data:', error);
            });
        }

        // Add event listeners for filter changes
        document.getElementById('graphType').addEventListener('change', updateGraph);
        document.getElementById('departmentFilter').addEventListener('change', updateGraph);
        document.getElementById('semesterFilter').addEventListener('change', updateGraph);

        // Initialize with default data
        updateGraph();
      </script>
    </div>

    <!-- Teacher Section -->
    <div class="teacher-section bg-white p-6 rounded-lg shadow-lg mx-4 mb-10 md:mx-auto max-w-7xl" id="teachers-section">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Teachers Profile Information</h2>

      <form class="teacher-form space-y-4" id="teacherForm" method="POST" enctype="multipart/form-data">
        <!-- Grid layout for form fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <!-- Profile Photo -->
          <div class="col-span-1 md:col-span-2">
            <label class="flex flex-col items-center px-4 py-6 bg-gray-50 text-gray-700 rounded-lg border border-blue-500 cursor-pointer hover:bg-blue-100 transition-colors duration-200">
              <svg class="w-8 h-8 text-blue-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                  <animate
                    attributeName="stroke-dasharray"
                    values="1,150;150,1"
                    dur="2s"
                    repeatCount="indefinite" />
                  <animate
                    attributeName="stroke-width"
                    values="2;2;2"
                    dur="2s"
                    repeatCount="indefinite" />
                  <animate
                    attributeName="opacity"
                    values="0.3;1;0.3"
                    dur="2s"
                    repeatCount="indefinite" />
                </path>
              </svg>
              <span class="mt-2 text-base">Upload Student Photo</span>
              <input type="file" name="profile_photo" class="hidden" required />
            </label>
          </div>

          <!-- Name -->
          <div class="relative">
            <input type="text" name="name" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Full Name" required />
          </div>

          <!-- Date of Birth -->
          <div class="relative">
            <input type="date" name="dob" class="w-full px-4 py-2 text-gray-400 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" title="Enter Date Of Birth" required />
          </div>

          <!-- Date of Joining -->
          <div class="relative">
            <input type="date" name="doj" class="w-full px-4 py-2 text-gray-400 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" title="Enter Date Of Joining" required />
          </div>

          <!-- Email -->
          <div class="relative">
            <input type="email" name="email" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Email" required />
          </div>

          <!-- Password -->
          <div class="relative">
            <input type="password" name="password" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Password" required />
          </div>

          <!-- Phone -->
          <div class="relative">
            <input type="text" name="phone" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Phone Number" required />
          </div>

          <!-- Address -->
          <div class="relative col-span-1 md:col-span-2">
            <textarea name="address" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Address" required rows="3"></textarea>
          </div>

          <!-- Department -->
          <div class="relative">
            <input type="text" name="department" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Department" required />
          </div>

          <!-- Qualification -->
          <div class="relative">
            <input type="text" name="qualification" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Qualification" required />
          </div>

          <!-- Experience -->
          <div class="relative">
            <input type="text" name="experience" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Experience" required />
          </div>

          <!-- Specialization -->
          <div class="relative">
            <input type="text" name="specialization" class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200" placeholder="Specialization" required />
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center mt-6">
          <button type="submit" name="add_teacher" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
            Add Teacher
          </button>
        </div>
      </form>

      <!-- View Teachers Table -->
      <div class="table-responsive overflow-x-auto h-[70vh] mt-20 shadow-md rounded-lg w-full bg-white p-6 mx-4 md:mx-auto max-w-7xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-5 text-center">Teachers Information</h2>
        <table class="teacher-table min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0 z-10">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Password</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qualification</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Birth Date</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Join Date</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialization</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php
            // Include your database connection file
            include('db_connection.php');

            // Check if the action is to delete a teacher
            if (isset($_POST['action']) && $_POST['action'] == 'delete_teacher' && isset($_POST['teacher_id'])) {
              $teacher_id = $_POST['teacher_id'];

              // Prepare the DELETE SQL query
              $query = "DELETE FROM teacher_mst WHERE teacher_id = ?";

              if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $teacher_id);
                if ($stmt->execute()) {
                  echo "Teacher deleted successfully";
                } else {
                  echo "Error: Could not delete teacher";
                }
                $stmt->close();
              } else {
                echo "Error: Could not prepare SQL query";
              }
            }

            $conn = new mysqli($servername, $username, $password, $dbname);
            $result = $conn->query("SELECT * FROM teacher_mst");

            while ($row = $result->fetch_assoc()) {
              echo "<tr class='hover:bg-gray-50 transition-colors duration-200'>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['teacher_id']}</td>
              
              <td class='px-6 py-4 whitespace-nowrap'>
                <div class='flex items-center'>
                  <div class='h-10 w-10 flex-shrink-0'>
                    <img class='h-10 w-10 rounded-full object-cover shadow-sm' 
                       src='uploads/teachers{$row['profile_photo']}' 
                       alt='Profile Photo'>
                  </div>
                </div>
              </td>
              
              <td class='px-6 py-4 whitespace-nowrap'>
                <div class='text-sm font-medium text-gray-900'>{$row['name']}</div>
              </td>
              
              <td class='px-6 py-4 whitespace-nowrap'>
                <div class='text-sm text-gray-500'>{$row['email']}</div>
              </td>
              
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['password']}</td>
              
              <td class='px-6 py-4 whitespace-nowrap'>
                <div class='text-sm text-gray-500'>{$row['phone']}</div>
              </td>
              
              <td class='px-6 py-4 text-sm text-gray-500'>
                <div class='max-w-xs truncate'>{$row['address']}</div>
              </td>
              
              <td class='px-6 py-4 whitespace-nowrap'>
                <span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800'>
                  {$row['department']}
                </span>
              </td>
              
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['qualification']}</td>
              
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . date('Y-m-d', strtotime($row['dob'])) . "</td>
              
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . date('Y-m-d', strtotime($row['doj'])) . "</td>
              
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['experience']}</td>
              
              <td class='px-6 py-4 whitespace-nowrap'>
                <span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'>
                  {$row['specialization']}
                </span>
              </td>
              
              <td class='px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2'>
                <button onclick='showUpdateForm({$row['teacher_id']}, this)' 
                    data-teacher='" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . "'
                    class='inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200'>
                  <svg class='h-4 w-4 mr-1.5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'/>
                  </svg>
                  Update
                </button>
                
                <button onclick='deleteTeacher({$row['teacher_id']})'
                    class='inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200'>
                  <svg class='h-4 w-4 mr-1.5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'/>
                  </svg>
                  Delete
                </button>
              </td>
            </tr>";
            }
            ?>


            <div id="updateTeacherModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
              <div class="min-h-screen px-4 text-center">
                <div class="inline-block w-full max-w-3xl p-6 my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                  <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Update Teacher Information</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                      <span class="sr-only">Close</span>
                      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>

                  <form id="updateTeacherForm" method="POST" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" id="existing_photo" name="existing_photo">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div class="col-span-2">
                        <label class="flex flex-col items-center px-4 py-6 bg-white text-gray-700 rounded-lg border-2 border-dashed border-gray-300 cursor-pointer hover:border-blue-500">
                          <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                          <span class="mt-2 text-sm text-gray-600">Update Profile Photo</span>
                          <input type="file" id="profile_photo" name="profile_photo" class="hidden">
                        </label>
                      </div>

                      <div class="space-y-1">
                        <label for="teacher_id" class="text-sm font-medium text-gray-700">Teacher ID</label>
                        <input type="text" id="teacher_id" name="teacher_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="name" class="text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="dob" class="text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="doj" class="text-sm font-medium text-gray-700">Date of Joining</label>
                        <input type="date" id="doj" name="doj" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="phone" class="text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" id="phone" name="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="department" class="text-sm font-medium text-gray-700">Department</label>
                        <input type="text" id="department" name="department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="col-span-2">
                        <label for="address" class="text-sm font-medium text-gray-700">Address</label>
                        <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                      </div>

                      <div class="space-y-1">
                        <label for="qualification" class="text-sm font-medium text-gray-700">Qualification</label>
                        <input type="text" id="qualification" name="qualification" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="experience" class="text-sm font-medium text-gray-700">Experience</label>
                        <input type="text" id="experience" name="experience" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>

                      <div class="space-y-1">
                        <label for="specialization" class="text-sm font-medium text-gray-700">Specialization</label>
                        <input type="text" id="specialization" name="specialization" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                      <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                      </button>
                      <button type="button" onclick="updateTeacher()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Teacher
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </table>
      </div>
    </div>

    <!-- Student Section -->
    <div class="student-section bg-white p-6 rounded-lg shadow-lg mx-4 mb-10 md:mx-auto max-w-7xl" id="students-section">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Student Details Information</h2>

      <form class="space-y-4" id="studentForm" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Student ID & Name -->
          <div>
            <input type="text" name="student_id"
              class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              placeholder="Student ID" required />
          </div>
          <div>
            <input type="text" name="name"
              class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              placeholder="Name" required />
          </div>

          <!-- Department, Division & Semester -->
          <div>
            <select name="department"
              class="w-full px-4 py-2 text-gray-400 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              required>
              <option value="" disabled selected>Department</option>
              <option value="FY BCA">FY BCA</option>
              <option value="SY BCA">SY BCA</option>
              <option value="TY BCA">TY BCA</option>
              <option value="FY BSc CA & IT">FY BSc CA & IT</option>
              <option value="SY BSc CA & IT">SY BSc CA & IT</option>
              <option value="TY BSc CA & IT">TY BSc CA & IT</option>
            </select>
          </div>

          <div>
            <select name="division"
              class="w-full px-4 py-2 text-gray-400 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              required>
              <option value="" disabled selected>Division</option>
              <option value="Division A">Division A</option>
              <option value="Division B">Division B</option>
              <option value="Division C">Division C</option>
              <option value="Division D">Division D</option>
            </select>
          </div>

          <div>
            <select name="semester"
              class="w-full px-4 py-2 text-gray-400 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              required>
              <option value="" disabled selected>Semester</option>
              <?php for ($i = 1; $i <= 6; $i++): ?>
                <option value="<?php echo $i; ?>">Semester <?php echo $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <!-- Roll Number, Email & Phone -->
          <div>
            <input type="text" name="roll_number"
              class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              placeholder="Roll Number" required />
          </div>

          <div>
            <input type="email" name="email"
              class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              placeholder="Email" required />
          </div>

          <div>
            <input type="text" name="phone"
              class="w-full px-4 py-2 text-gray-700 bg-gray-50 rounded border border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-colors duration-200"
              placeholder="Phone Number" required />
          </div>

          <!-- Photo Upload -->
          <div class="col-span-1 md:col-span-2">
            <label class="flex flex-col items-center px-4 py-6 bg-blue-50 text-gray-700 rounded-lg border border-blue-500 cursor-pointer hover:bg-blue-100 transition-colors duration-200">
              <svg class="w-8 h-8 text-blue-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                  <animate
                    attributeName="stroke-dasharray"
                    values="1,150;150,1"
                    dur="2s"
                    repeatCount="indefinite" />
                  <animate
                    attributeName="stroke-width"
                    values="2;2;2"
                    dur="2s"
                    repeatCount="indefinite" />
                  <animate
                    attributeName="opacity"
                    values="0.3;1;0.3"
                    dur="2s"
                    repeatCount="indefinite" />
                </path>
              </svg>
              <span class="mt-2 text-base">Upload Student Photo</span>
              <input type="file" name="photo" class="hidden" required />
            </label>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mt-6">
          <button type="submit" name="add_student"
            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
            Add Student
          </button>
          <button type="submit" name="update_student"
            class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
            Update Student
          </button>
        </div>
      </form>

      <!-- Student Table -->
      <div class="student-table-section bg-white p-6 rounded-lg shadow-lg mx-4 mt-12 mb-10 md:mx-auto max-w-7xl" id="student-table-section" style="display:none; height: 70vh; overflow-y: auto;">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Students Information</h2>
        <div class="overflow-x-auto">
          <div class="inline-block min-w-full py-2 align-middle">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Photo</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Student ID</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Roll Number</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Department</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Division</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Semester</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <?php
                  $sql = "SELECT * FROM student_mst";
                  $result = $conn->query($sql);

                  if ($result === false) {
                    echo "<tr><td colspan='10' class='px-3 py-4 text-sm text-center text-gray-500'>Error: " . $conn->error . "</td></tr>";
                  } else if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr id='student-row-" . $row['roll_number'] . "' class='hover:bg-gray-50'>
                        <td class='whitespace-nowrap py-4 pl-4 pr-3 text-sm'>
                          <img src='uploads/students/" . $row['photo'] . "' alt='Student Photo' class='h-10 w-10 rounded-full object-cover'>
                        </td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['student_id'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['name'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['roll_number'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['department'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['division'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['semester'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['email'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm text-gray-500'>" . $row['phone'] . "</td>
                        <td class='whitespace-nowrap px-3 py-4 text-sm'>
                          <button onclick='deleteStudent(\"" . addslashes($row['roll_number']) . "\")' 
                            class='inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg transition-colors duration-200 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-sm gap-2'>
                            Delete Student
                          </button>
                        </td>
                      </tr>";
                    }
                  } else {
                    echo "<tr><td colspan='10' class='px-3 py-4 text-sm text-center text-gray-500'>No students found</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Attendance Section -->
    <div class="attendance-section bg-white p-6 rounded-lg shadow-lg mx-4 mt-8 mb-10 md:mx-auto max-w-7xl" id="attendance-section" style="display: none;">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">View Attendance Data</h2>

      <!-- Filters Section -->
      <div class="mb-6">
        <form id="attendanceFilterForm" method="POST" class="space-y-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

            <!-- Department Dropdown -->
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
              <select name="department" class="departmentDropdown appearance-none block w-full px-3 py-2 border border-blue-500 text-gray-400 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">All Departments</option>
                <option value="FY BCA">FY BCA</option>
                <option value="SY BCA">SY BCA</option>
                <option value="TY BCA">TY BCA</option>
                <option value="FY BSc CA & IT">FY BSc CA & IT</option>
                <option value="SY BSc CA & IT">SY BSc CA & IT</option>
                <option value="TY BSc CA & IT">TY BSc CA & IT</option>
              </select>
            </div>

            <!-- Division Dropdown -->
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-1">Division</label>
              <select name="division" class="divisionDropdown appearance-none block w-full px-3 py-2 border border-blue-500 text-gray-400 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">All Divisions</option>
                <option value="Division A">Division A</option>
                <option value="Division B">Division B</option>
                <option value="Division C">Division C</option>
                <option value="Division D">Division D</option>
              </select>
            </div>

            <!-- Semester Dropdown -->
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
              <select name="semester" class="semesterDropdown appearance-none block w-full px-3 py-2 border border-blue-500 text-gray-400 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">All Semesters</option>
                <?php for ($i = 1; $i <= 6; $i++): ?>
                  <option value="<?php echo $i; ?>">Semester <?php echo $i; ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <!-- Date Range -->
            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
              <input type="date" name="from_date" class="startDateInput block w-full px-3 py-2 border border-blue-500 rounded-md text-gray-400 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
            </div>

            <div class="relative">
              <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
              <input type="date" name="to_date" class="endDateInput block w-full px-3 py-2 border border-blue-500 rounded-md text-gray-400 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
            </div>

          </div>

          <!-- Action Buttons -->
          <!-- <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-2 items-center justify-center"> -->
          <div class="flex flex-col space-y-2 sm:space-y-0 sm:flex-row sm:space-x-2 items-end">
            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              <span class="flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View Attendance
              </span>
            </button>

            <button type="button" id="generateReportBtn" class="w-full sm:w-auto px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
              <span class="flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download Report
              </span>
            </button>
          </div>
        </form>
      </div>

      <!-- Table Section -->
      <div class="overflow-x-auto mt-20 shadow-md rounded-lg h-[70vh]">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Students Attendance Information</h2>
        <table id="attendanceTable" class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0 z-10">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll Number</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Division</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance Date</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php
            $sql = "SELECT * FROM attendance_mst WHERE 1=1";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $department = isset($_POST['department']) ? $_POST['department'] : '';
              $division = isset($_POST['division']) ? $_POST['division'] : '';
              $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
              $fromDate = isset($_POST['from_date']) ? $_POST['from_date'] : '';
              $toDate = isset($_POST['to_date']) ? $_POST['to_date'] : '';

              if (!empty($department)) {
                $sql .= " AND department = '" . $conn->real_escape_string($department) . "'";
              }
              if (!empty($division)) {
                $sql .= " AND division = '" . $conn->real_escape_string($division) . "'";
              }
              if (!empty($semester)) {
                $sql .= " AND semester = '" . $conn->real_escape_string($semester) . "'";
              }
              if (!empty($fromDate) && !empty($toDate)) {
                $sql .= " AND attendance_date BETWEEN '" . $conn->real_escape_string($fromDate) . "' 
               AND '" . $conn->real_escape_string($toDate) . "'";
              }
            }

            $result = $conn->query($sql);

            if ($result === false) {
              echo "<tr><td colspan='9' class='px-6 py-4 text-center text-sm text-gray-500'>Error: " . $conn->error . "</td></tr>";
            } else if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr class='hover:bg-gray-50'>
              <td class='px-6 py-4 whitespace-nowrap'>
                <img src='uploads/students/" . htmlspecialchars($row['photo']) . "' alt='Student Photo' 
                 class='h-10 w-10 rounded-full object-cover'>
              </td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['id']) . "</td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['name']) . "</td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['roll_number']) . "</td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['department']) . "</td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['division']) . "</td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['semester']) . "</td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['attendance_date']) . "</td>
              <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($row['status']) . "</td>
            </tr>";
              }
            } else {
              echo "<tr><td colspan='9' class='px-6 py-4 text-center text-sm text-gray-500'>No records found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Admin Profile Section -->
    <div id="profile-section" class="hidden">
      <div class="max-w-4xl mx-auto p-4 mt-10 mb-10 sm:p-6 lg:p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-5 text-gray-900 mb-6">Admin Profile</h2>

        <form id="profileForm" method="POST" action="admin-dashboard.php" enctype="multipart/form-data">
          <!-- Profile Image Section -->
          <div class="mb-8">
            <div class="flex flex-col items-center">
              <div class="relative w-32 h-32 mb-4">
                <img src="<?php echo isset($admin_data['profile_image']) ? 'uploads/admin/' . $admin_data['profile_image'] : 'Coder.png'; ?>" alt="Admin Profile" class="w-full h-full object-cover rounded-full border-4 border-gray-200" id="profile-image" />
                <input type="file" id="profile-image-input" name="profile_image" class="hidden" onchange="previewImage(event)" />
              </div>
            </div>
          </div>

          <div class="space-y-8">
            <!-- Personal Information -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Personal Information</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                  <span class="block text-gray-900" id="full_name_text"><?php echo $admin_data['full_name'] ?? ''; ?></span>
                  <input type="text" name="full_name" id="full_name" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $admin_data['full_name'] ?? ''; ?>" required />
                </div>

                <div>
                  <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                  <span class="block text-gray-900" id="dob_text"><?php echo $admin_data['dob'] ?? ''; ?></span>
                  <input type="date" name="dob" id="dob" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $admin_data['dob'] ?? ''; ?>" required />
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                  <span class="block text-gray-900" id="email_text"><?php echo $admin_data['email'] ?? ''; ?></span>
                  <input type="email" name="email" id="email" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $admin_data['email'] ?? ''; ?>" required />
                </div>

                <div>
                  <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                  <span class="block text-gray-900" id="phone_text"><?php echo $admin_data['phone'] ?? ''; ?></span>
                  <input type="tel" name="phone" id="phone" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $admin_data['phone'] ?? ''; ?>" required />
                </div>

                <div class="md:col-span-2">
                  <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                  <span class="block text-gray-900" id="address_text"><?php echo $admin_data['address'] ?? ''; ?></span>
                  <textarea name="address" id="address" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3" required><?php echo $admin_data['address'] ?? ''; ?></textarea>
                </div>
              </div>
            </div>

            <!-- Professional Information -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Professional Information</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                  <span class="block text-gray-900" id="role_text"><?php echo $admin_data['role'] ?? ''; ?></span>
                  <select name="role" id="role" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="administrator" <?php echo ($admin_data['role'] ?? '') == 'administrator' ? 'selected' : ''; ?>>Administrator</option>
                    <option value="manager" <?php echo ($admin_data['role'] ?? '') == 'manager' ? 'selected' : ''; ?>>Manager</option>
                  </select>
                </div>

                <div>
                  <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                  <span class="block text-gray-900" id="department_text"><?php echo $admin_data['department'] ?? ''; ?></span>
                  <input type="text" name="department" id="department" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $admin_data['department'] ?? ''; ?>" required />
                </div>

                <div>
                  <label for="doj" class="block text-sm font-medium text-gray-700 mb-1">Date of Joining</label>
                  <span class="block text-gray-900" id="doj_text"><?php echo $admin_data['doj'] ?? ''; ?></span>
                  <input type="date" name="doj" id="doj" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $admin_data['doj'] ?? ''; ?>" required />
                </div>

                <div>
                  <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                  <span class="block text-gray-900" id="status_text"><?php echo $admin_data['status'] ?? ''; ?></span>
                  <select name="status" id="status" class="hidden mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="active" <?php echo ($admin_data['status'] ?? '') == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($admin_data['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="mt-8 flex justify-end space-x-4">
            <button type="button" id="editProfileBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors" onclick="toggleEditProfile(event)">
              Edit Profile
            </button>
            <button type="submit" name="save_profile" id="saveProfileBtn" class="hidden px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
              Save Profile
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<script src="assets/Js/adminDashboard.js">
  // JavaScript to handle form submission and prevent page reload
  document.getElementById("attendanceFilterForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevents the form from submitting and reloading the page
  });
</script>

</html>