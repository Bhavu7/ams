<?php
// Include database connection
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $teacher_id = $_POST['teacher_id'];
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
    
    // Handle file upload for profile photo (if any)
    if ($_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
        $profile_photo = $_FILES['profile_photo'];
        $photo_name = $teacher_id . "_" . basename($profile_photo["name"]);
        $photo_tmp_name = $profile_photo["tmp_name"];
        $upload_dir = "uploads/"; // Ensure this directory exists and is writable
        
        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($photo_tmp_name, $upload_dir . $photo_name)) {
            $photo_path = $upload_dir . $photo_name;
        } else {
            // Handle upload error if needed
            $photo_path = null;
        }
    } else {
        // If no new photo is uploaded, keep the existing photo path
        $photo_path = $_POST['existing_photo'];
    }

    // Update teacher record in the database
    $query = "UPDATE teacher_mst SET 
              name = ?, dob = ?, doj = ?, email = ?, password = ?, 
              phone = ?, address = ?, department = ?, qualification = ?, 
              experience = ?, specialization = ?, profile_photo = ? 
              WHERE teacher_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssssi", $name, $dob, $doj, $email, $password, 
                     $phone, $address, $department, $qualification, $experience, 
                     $specialization, $photo_path, $teacher_id);

    // Execute the query and check for errors
    if ($stmt->execute()) {
        // Fetch the updated teacher data to return as JSON
        $stmt->close();
        $query = "SELECT * FROM teacher_mst WHERE teacher_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $updatedTeacher = $result->fetch_assoc();
        
        echo json_encode($updatedTeacher); // Return updated teacher data as JSON
    } else {
        echo "Error updating teacher: " . $stmt->error;
    }
    $conn->close();
}
?>
