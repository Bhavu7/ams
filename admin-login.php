<?php
session_start();
include 'db_connection.php';

function reset_password($email, $new_password) {
    global $conn;

    // Check if the email exists before attempting to reset the password
    $check_sql = "SELECT * FROM admin_login WHERE email=?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Email exists, so reset the password (hash the new password)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Secure hash
        $sql = "UPDATE admin_login SET password=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $email);
        return $stmt->execute();
    } else {
        // Email doesn't exist
        return false;
    }
}


$loginMessage = "";
$resetMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Login
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Sanitize and validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $loginMessage = "Invalid email format.";
        } else {
            $query = $conn->prepare("SELECT id, password FROM admin_login WHERE email = ?");
            $query->bind_param("s", $email); // 's' for string
            $query->execute();
            $result = $query->get_result();

            // If email exists in the database
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $storedPassword = $row['password'];

                // Compare the input password with the hashed password
                if (password_verify($password, $storedPassword)) {
                    // Password is correct, start a session and store admin_id
                    $_SESSION['admin_id'] = $row['id'];
                    header("Location: admin-dashboard.php"); // Redirect to the dashboard or profile page
                    exit();
                } else {
                    $loginMessage = "Invalid password. Please try again.";
                }
            } else {
                $loginMessage = "No account found with that email address.";
            }
            $query->close();
        }
    }
    
    // Handle Password Reset
    if (isset($_POST['reset_password'])) {
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $new_password = $_POST['newPassword'];
        $confirm_password = $_POST['confirmPassword'];

        if ($new_password === $confirm_password) {
            if (reset_password($email, $new_password)) {
                $resetMessage = "Your password has been reset successfully.";
            } else {
                $resetMessage = "Email not found. Unable to reset password.";
            }
        } else {
            $resetMessage = "Passwords do not match. Please try again.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMS Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\assets\offline\admin\login\css2.css">
    <link rel="stylesheet" href="\assets\offline\admin\login\all.min.css">
    <script src="\assets\offline\admin\login\gsap.min.js"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f6f7ff 0%, #eef1ff 100%);
            min-height: 100vh;
        }
        
            .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1a73e8, #34a853);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
</style>
<body class="min-h-screen bg-gray-50">
                <!-- Navigation -->
                <nav class="glass-card sticky top-0 z-50 backdrop-blur-lg border-b border-gray-200/30 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Left side - Logo and Title -->
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            <img src="images/cesLogo.png" alt="College Logo"
                                class="h-14 w-auto rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105">
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-lg md:text-xl font-bold gradient-text">Attendance Management System</h1>
                            <p class="text-xs md:text-sm text-gray-600">Shri Dadabhai Naroji Institute</p>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        
    <div class="flex min-h-screen items-center justify-center p-4" id="container">
        <!-- Main Container -->
        <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white/10 backdrop-blur-lg shadow-2xl">
            <!-- Glass Header -->
            <div class="bg-blue-600 p-8 text-center">
                <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-gray-50 flex items-center justify-center">
                    <i class="fas fa-user-shield text-2xl text-blue-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-100" id="formTitle">Admin Login</h1>
                <p class="mt-2 text-sm text-gray-50">Access your administrative dashboard</p>
            </div>

            <!-- Forms Container -->
            <div class="p-8">
                <!-- Login Form -->
                <form method="post" action="admin-login.php" class="space-y-6" id="loginForm">
                    <div class="space-y-4">
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-envelope text-blue-300"></i>
                            </div>
                            <input type="email" id="email" name="email" required
                                class="block w-full rounded-lg border border-blue-400 bg-white/5 pl-10 pr-4 py-3 text-gray-600 placeholder:text-gray/60 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                                placeholder="Admin Email">
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-blue-300"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="block w-full rounded-lg border border-blue-400 bg-white/5 pl-10 pr-4 py-3 text-gray-600 placeholder:text-gray/60 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                                placeholder="Password">
                        </div>
                    </div>

                    <button type="submit" name="login"
                        class="group relative flex w-full justify-center rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt"></i>
                        </span>
                        Login to Dashboard
                    </button>

                    <div class="text-center">
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 transition-colors" onclick="showResetForm()">
                            Forgot your password?
                        </a>
                    </div>
                </form>

                <!-- Reset Password Form -->
                <form method="post" action="" class="hidden space-y-6" id="resetForm">
                    <div class="space-y-4">
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-envelope text-blue-300"></i>
                            </div>
                            <input type="email" id="resetEmail" name="email" required
                                class="block w-full rounded-lg border border-blue-600 bg-white/5 pl-10 pr-4 py-3 text-gray-600 placeholder:text-gray/60 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                                placeholder="Admin Email">
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-key text-blue-300"></i>
                            </div>
                            <input type="password" id="newPassword" name="newPassword" required
                                class="block w-full rounded-lg border border-blue-600 bg-white/5 pl-10 pr-4 py-3 text-gray-600 placeholder:text-gray/60 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                                placeholder="New Password">
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-blue-300"></i>
                            </div>
                            <input type="password" id="confirmPassword" name="confirmPassword" required
                                class="block w-full rounded-lg border border-blue-600 bg-white/5 pl-10 pr-4 py-3 text-gray-600 placeholder:text-gray/60 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                                placeholder="Confirm Password">
                        </div>
                    </div>

                    <button type="submit" name="reset_password"
                        class="group relative flex w-full justify-center rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-key"></i>
                        </span>
                        Reset Password
                    </button>

                    <div class="text-center">
                        <a href="#" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 transition-colors" onclick="showLoginForm()">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        <?php if ($loginMessage): ?>
            alert("<?php echo $loginMessage; ?>");
        <?php endif; ?>

        <?php if ($resetMessage): ?>
            alert("<?php echo $resetMessage; ?>");
        <?php endif; ?>

        // Enhanced animations
        gsap.from("#container", {
            duration: 1.2,
            opacity: 0,
            y: 30,
            ease: "power4.out"
        });

        function showResetForm() {
            gsap.to("#loginForm", {
                duration: 0.4,
                opacity: 0,
                scale: 0.95,
                onComplete: function() {
                    document.getElementById("loginForm").style.display = "none";
                    document.getElementById("resetForm").style.display = "block";
                    document.getElementById("formTitle").textContent = "Reset Password";
                    gsap.fromTo("#resetForm",
                        { opacity: 0, scale: 0.95 },
                        { opacity: 1, scale: 1, duration: 0.4 }
                    );
                }
            });
        }

        function showLoginForm() {
            gsap.to("#resetForm", {
                duration: 0.4,
                opacity: 0,
                scale: 0.95,
                onComplete: function() {
                    document.getElementById("resetForm").style.display = "none";
                    document.getElementById("loginForm").style.display = "block";
                    document.getElementById("formTitle").textContent = "Admin Login";
                    gsap.fromTo("#loginForm",
                        { opacity: 0, scale: 0.95 },
                        { opacity: 1, scale: 1, duration: 0.4 }
                    );
                }
            });
        }
    </script>
</body>
</html>