function logout() {
  // Confirm logout action
  if (confirm("Are you sure you want to log out?")) {
    // Redirect to the logout PHP script
    window.location.href = "teacher-login.php";
  }
}

// Section display functions
function showDashboard() {
  document.getElementById("dashboard-section").style.display = "block";
  document.getElementById("reports-section").style.display = "none";
  document.getElementById("attendance-section").style.display = "none";
  document.getElementById("profile-section").style.display = "none";
}

function toggleStudentReport() {
  document.getElementById("dashboard-section").style.display = "none";
  document.getElementById("reports-section").style.display = "block";
  document.getElementById("attendance-section").style.display = "none";
  document.getElementById("profile-section").style.display = "none";
}

function showAttendance() {
  document.getElementById("dashboard-section").style.display = "none";
  document.getElementById("reports-section").style.display = "none";
  document.getElementById("attendance-section").style.display = "block";
  document.getElementById("profile-section").style.display = "none";
}

function showProfile() {
  document.getElementById("dashboard-section").style.display = "none";
  document.getElementById("reports-section").style.display = "none";
  document.getElementById("attendance-section").style.display = "none";
  document.getElementById("profile-section").style.display = "block";
}

function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function () {
    const output = document.getElementById("profile-preview");
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}

// Profile editing functionality
let isEditing = false;

function toggleEditProfile() {
  const profileDetails = document.querySelector(".profile-details");
  const editBtn = document.getElementById("editProfileBtn");
  const inputs = document.querySelectorAll(".profile-input");
  const imageInput = document.getElementById("profile-image-input");

  isEditing = !isEditing;

  if (isEditing) {
    profileDetails.classList.add("editing");
    // Set button text and toggle input/edit mode
    editBtn.textContent = "Save Changes";
    inputs.forEach((input) => input.removeAttribute("disabled"));
    imageInput.style.display = "block";
  } else {
    profileDetails.classList.remove("editing");
    editBtn.textContent = "Edit Profile";
    inputs.forEach((input) => input.setAttribute("disabled", "disabled"));
    imageInput.style.display = "none";
  }
}

function handleExcelUpload() {
  const fileInput = document.getElementById("excelFile");
  const uploadStatus = document.getElementById("uploadStatus");

  if (!fileInput.files.length) {
    uploadStatus.innerHTML =
      '<div class="text-red-600">Please select a file first.</div>';
    return;
  }

  const formData = new FormData();
  formData.append("excelFile", fileInput.files[0]);

  // Display loading status
  uploadStatus.innerHTML =
    '<div class="text-blue-600">Uploading and processing data...</div>';

  fetch("upload_excel.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        uploadStatus.innerHTML = `
              <div class="text-green-600">${data.message}</div>
              ${
                data.errors.length > 0
                  ? `<div class="mt-4 text-red-600">
                      <strong>Errors:</strong>
                      <ul class="list-disc pl-5">
                          ${data.errors
                            .map((error) => `<li>${error}</li>`)
                            .join("")}
                      </ul>
                  </div>`
                  : ""
              }`;

        // Clear the file input after successful upload
        fileInput.value = "";
      } else {
        uploadStatus.innerHTML = `<div class="text-red-600">Error: ${data.message}</div>`;
      }
    })
    .catch((error) => {
      uploadStatus.innerHTML = `<div class="text-red-600">Error: ${error.message}</div>`;
    });
}
