function showPopupMessage(message) {
  alert(message); // Show popup message
}

// Reset teacher fields
function resetTeacherFields() {
  const form = document.getElementById("teacherForm");
  form.reset();
}

// Reset student fields
function resetStudentFields() {
  const form = document.getElementById("studentForm");
  form.reset();
}

// Show Graph Section
function showGraph() {
  document.querySelector("#teachers-section").style.display = "none";
  document.querySelector("#graph-section").style.display = "block";
  document.querySelector("#profile-section").style.display = "none";
  document.querySelector(".student-section").style.display = "none";
  document.querySelector(".attendance-section").style.display = "none";
  document.querySelector(".table-responsive").style.display = "none";
  document.querySelector(".student-table-section").style.display = "none";
}

// Show Students Section
function showStudents() {
  document.querySelector(".teacher-section").style.display = "none";
  document.querySelector(".student-section").style.display = "block";
  document.querySelector("#graph-section").style.display = "none";
  document.querySelector("#profile-section").style.display = "none";
  document.querySelector(".attendance-section").style.display = "none";
  document.querySelector(".table-responsive").style.display = "none";
  document.querySelector(".student-table-section").style.display = "block";
}

// Show Teachers Section
function showTeachers() {
  document.getElementById("graph-section").style.display = "none";
  document.getElementById("teachers-section").style.display = "block";
  document.querySelector("#profile-section").style.display = "none";
  document.querySelector(".student-section").style.display = "none";
  document.querySelector(".attendance-section").style.display = "none";
  document.querySelector(".table-responsive").style.display = "block";
  document.querySelector(".student-table-section").style.display = "none";
}

// Add this to your navigation click handlers
function showAttendance() {
  document.querySelector(".teacher-section").style.display = "none";
  document.querySelector(".student-section").style.display = "none";
  document.querySelector("#graph-section").style.display = "none";
  document.querySelector("#profile-section").style.display = "none";
  document.querySelector("#attendance-section").style.display = "block";
  document.querySelector(".table-responsive").style.display = "none";
  document.querySelector(".student-table-section").style.display = "none";
}

// show profile section
function showProfile() {
  document.querySelector(".teacher-section").style.display = "none";
  document.querySelector(".student-section").style.display = "none";
  document.querySelector("#graph-section").style.display = "none";
  document.querySelector("#profile-section").style.display = "block";
  document.querySelector(".attendance-section").style.display = "none";
  document.querySelector(".table-responsive").style.display = "none";
  document.querySelector(".student-table-section").style.display = "none";
}

// Function to show the modal and populate it with the current teacher's data
function showUpdateForm(teacherId, buttonElement) {
  const teacherData = JSON.parse(buttonElement.getAttribute("data-teacher"));

  // Populate the modal form with teacher's data
  document.getElementById("teacher_id").value = teacherData.teacher_id;
  document.getElementById("existing_photo").value = teacherData.profile_photo;
  document.getElementById("name").value = teacherData.name;
  document.getElementById("email").value = teacherData.email;
  document.getElementById("phone").value = teacherData.phone;
  document.getElementById("address").value = teacherData.address;
  document.getElementById("department").value = teacherData.department;
  document.getElementById("qualification").value = teacherData.qualification;
  document.getElementById("dob").value = teacherData.dob;
  document.getElementById("doj").value = teacherData.doj;
  document.getElementById("experience").value = teacherData.experience;
  document.getElementById("specialization").value = teacherData.specialization;

  // Show the modal
  document.getElementById("updateTeacherModal").style.display = "block";
}

// Close the modal
function closeModal() {
  document.getElementById("updateTeacherModal").style.display = "none";
}

function updateTeacher() {
  const form = document.getElementById("updateTeacherForm");
  const formData = new FormData(form); // Collect form data, including file

  // Create a new AJAX request to send the form data to the server
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "update_teacher.php", true);

  // Handle the response from the server
  xhr.onload = function () {
    if (xhr.status == 200) {
      alert("Teacher updated successfully!");

      // Now refresh the table or update the specific row in the table
      // For example, let's say you want to replace the row of the updated teacher:
      const updatedTeacherData = JSON.parse(xhr.responseText); // Assuming server returns the updated data

      // Find the row corresponding to the updated teacher and replace it
      const teacherRow = document.querySelector(
        `#teacher-row-${updatedTeacherData.teacher_id}`
      );
      if (teacherRow) {
        teacherRow.innerHTML = `
          <td>${updatedTeacherData.teacher_id}</td>
          <td>${updatedTeacherData.name}</td>
          <td>${updatedTeacherData.dob}</td>
          <td>${updatedTeacherData.doj}</td>
          <td>${updatedTeacherData.email}</td>
          <td>${updatedTeacherData.phone}</td>
          <td>${updatedTeacherData.department}</td>
          <td><img src="${updatedTeacherData.profile_photo}" alt="Profile Photo" width="50"></td>
          <td><button class="update-button" onclick="showUpdateForm(${updatedTeacherData.teacher_id}, this)">Update Teacher</button></td>
        `;
      }
    } else {
      alert("Error updating teacher");
    }
  };

  // Send the form data to the server
  xhr.send(formData);
}

function toggleEditProfile(event) {
  const form = document.getElementById("profileForm");
  const editButton = document.getElementById("editProfileBtn");
  const saveButton = document.getElementById("saveProfileBtn");

  // Toggle visibility of form fields and buttons
  const fieldsToToggle = form.querySelectorAll('input, textarea, select');
  fieldsToToggle.forEach(field => field.classList.toggle('hidden'));
  
  const spanText = form.querySelectorAll('span');
  spanText.forEach(span => span.classList.toggle('hidden'));

  // Toggle button visibility
  editButton.classList.toggle('hidden');
  saveButton.classList.toggle('hidden');
}
