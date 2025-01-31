<?php
session_start([
    'cookie_httponly' => true,  // Prevent JavaScript access to session cookie
    'cookie_samesite' => 'Strict'  // Prevent CSRF attacks
]);

include 'db_connection.php';

// Set more aggressive caching prevention
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Define functions for password reset and email verification
function reset_password($email, $new_password)
{
    global $conn;
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $check_sql = "SELECT * FROM teacher_mst WHERE email=?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $sql = "UPDATE teacher_mst SET password=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $email);
        return $stmt->execute();
    } else {
        return false;
    }
}

$loginMessage = "";
$resetMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM teacher_mst WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stored_password = $user['password'];

            if (password_verify($password, $stored_password)) {
                $_SESSION['user'] = $user;
                header("Location: teacher-dashboard.php");
                exit;
            } else {
                $loginMessage = "Wrong email or password - Password mismatch";
            }
        } else {
            $loginMessage = "Wrong email or password - Email not found";
        }
    } elseif (isset($_POST['reset_password'])) {
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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Teacher Login For AMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\assets\offline\teacher\login\css2.css">
    <link rel="stylesheet" href="\assets\offline\teacher\login\all.min.css">
    <script src="\assets\offline\teacher\login\gsap.min.js"></script>
    <script src="\assets\offline\teacher\dashboard\3.4.16"></script>
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
        <div class="relative w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl sm:flex">
            <!-- Left Side - Decorative Section -->
            <div class="relative hidden w-1/2 bg-gradient-to-br from-green-400 to-green-600 p-12 text-white sm:block">
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold">Welcome Teacher</h2>
                    <p class="mt-4 text-lg text-green-100">"Access your dashboard to manage attendance, view reports, and update your profile seamlessly."</p>

                    <!-- Decorative Elements -->
                    <div class="mt-16">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-graduation-cap text-3xl"></i>
                            <p class="text-sm">Manage Students</p>
                        </div>
                        <div class="mt-6 flex items-center space-x-4">
                            <i class="fas fa-book text-3xl"></i>
                            <p class="text-sm">Track Attendance</p>
                        </div>
                        <div class="mt-6 flex items-center space-x-4">
                            <i class="fas fa-chart-line text-3xl"></i>
                            <p class="text-sm">Monitor Students Attendance</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Forms Section -->
            <div class="w-full p-8 sm:w-1/2">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl" id="formTitle">
                        Teacher Login
                    </h1>
                    <p class="mt-2 text-sm text-gray-600" id="formDescription">
                        Sign in to access your dashboard
                    </p>
                </div>

                <!-- Login Form -->
                <form method="post" action="teacher-login.php" class="mt-8 space-y-6" id="loginForm">
                    <?php if (!empty($loginMessage)): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($loginMessage); ?></p>
                    <?php endif; ?>

                    <div class="space-y-5">
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-4 py-3 text-gray-900 transition-colors placeholder:text-gray-500 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                placeholder="Enter your email">
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-4 py-3 text-gray-900 transition-colors placeholder:text-gray-500 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                placeholder="Enter your password">
                        </div>
                    </div>

                    <div>
                        <button type="submit" name="login"
                            class="group relative flex w-full justify-center rounded-lg bg-green-500 px-4 py-3 text-sm font-medium text-white transition-colors hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            Sign in
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="#" class="text-sm text-green-600 hover:text-green-500 transition-colors" onclick="showResetForm()">
                            Forgot your password?
                        </a>
                    </div>
                </form>

                <!-- Reset Password Form -->
                <form method="post" action="" class="mt-8 hidden space-y-6" id="resetForm">
                    <?php if (!empty($resetMessage)): ?>
                        <p class="text-red-500 text-sm"><?php echo htmlspecialchars($resetMessage); ?></p>
                    <?php endif; ?>

                    <div class="space-y-5">
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="resetEmail" name="email" required
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-4 py-3 text-gray-900 transition-colors placeholder:text-gray-500 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                placeholder="Enter your email">
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="newPassword" name="newPassword" required
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-4 py-3 text-gray-900 transition-colors placeholder:text-gray-500 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                placeholder="Enter new password">
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="confirmPassword" name="confirmPassword" required
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-4 py-3 text-gray-900 transition-colors placeholder:text-gray-500 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <div>
                        <button type="submit" name="reset_password"
                            class="group relative flex w-full justify-center rounded-lg bg-green-500 px-4 py-3 text-sm font-medium text-white transition-colors hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-key"></i>
                            </span>
                            Reset Password
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="#" class="text-sm text-green-600 hover:text-green-500 transition-colors" onclick="showLoginForm()">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Enhanced animations
        gsap.from("#container", {
            duration: 1,
            opacity: 0,
            y: 30,
            ease: "power3.out"
        });

        function showResetForm() {
            document.getElementById("loginForm").classList.add("hidden");
            document.getElementById("resetForm").classList.remove("hidden");
            document.getElementById("formTitle").textContent = "Reset Password";
            document.getElementById("formDescription").textContent = "Reset your password below";

            gsap.to("#loginForm", {
                duration: 0.3,
                opacity: 0,
                x: -20,
                onComplete: function() {
                    document.getElementById("loginForm").style.display = "none";
                    document.getElementById("resetForm").style.display = "block";
                    gsap.fromTo("#resetForm", {
                        opacity: 0,
                        x: 20
                    }, {
                        opacity: 1,
                        x: 0,
                        duration: 0.3
                    });
                }
            });
        }

        function showLoginForm() {
            document.getElementById('formTitle').textContent = 'Teacher Login';
            document.getElementById('formDescription').textContent = 'Sign in to access your dashboard';

            gsap.to("#resetForm", {
                duration: 0.3,
                opacity: 0,
                x: 20,
                onComplete: function() {
                    document.getElementById("resetForm").style.display = "none";
                    document.getElementById("loginForm").style.display = "block";
                    gsap.fromTo("#loginForm", {
                        opacity: 0,
                        x: -20
                    }, {
                        opacity: 1,
                        x: 0,
                        duration: 0.3
                    });
                }
            });
        }
    </script>
</body>

</html>