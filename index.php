<?php
// Include database connection
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System - Modern UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
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

        .login-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1a73e8, #34a853);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a73e8, #1557b0);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #34a853, #2d8745);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .footer-link {
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: #1a73e8;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
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
                            <p class="text-xs md:text-sm text-gray-600">Shri Dadabhai Naroji Institute Of Computer Applications</p>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Modern Alert Banner -->
        <div class="glass-card rounded-lg mx-4 md:mx-auto md:max-w-4xl mb-8 mt-6 transform hover:scale-[1.02] transition-all duration-300" id="alert-banner">
            <div class="flex items-center justify-between p-6 rounded-lg bg-gradient-to-r from-red-50 to-pink-50 border border-red-100">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-sm md:text-base text-gray-800 font-medium">
                        This portal is exclusively for <span class="text-red-600 font-semibold">College Faculty</span> and <span class="text-red-600 font-semibold">Administrative Staff</span>
                    </p>
                </div>
                <button class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Teacher Login Card -->
                    <div class="login-card glass-card rounded-xl p-6">
                        <div class="text-center mb-6">
                            <svg class="w-16 h-16 mx-auto mb-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Teacher Portal</h2>
                            <p class="text-gray-600 mb-6">Access attendance records and manage student data for your classes</p>
                            <form action="teacher-login.php" method="POST">
                                <button name="teacherLogin" aria-label="Login as Teacher" class="btn-secondary text-white px-6 py-3 rounded-lg font-medium w-full">
                                    Login as Teacher
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Admin Login Card -->
                    <div class="login-card glass-card rounded-xl p-6">
                        <div class="text-center mb-6">
                            <svg class="w-16 h-16 mx-auto mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Admin Portal</h2>
                            <p class="text-gray-600 mb-6">Manage system settings and generate comprehensive reports</p>
                            <form action="admin-login.php" method="POST">
                                <button name="adminLogin" aria-label="Login as Administrator" class="btn-primary text-white px-6 py-3 rounded-lg font-medium w-full">
                                    Login as Admin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="glass-card mt-24 bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Quick Links Section -->
                <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 tracking-wide">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                    <a href="#" class="group flex items-center text-gray-600 hover:text-blue-600 transition-colors duration-200">
                        <span class="mr-2">→</span>
                        <span class="border-b border-transparent group-hover:border-blue-600">Terms of Service</span>
                    </a>
                    </li>
                    <li>
                    <a href="#" class="group flex items-center text-gray-600 hover:text-blue-600 transition-colors duration-200">
                        <span class="mr-2">→</span>
                        <span class="border-b border-transparent group-hover:border-blue-600">Privacy Policy</span>
                    </a>
                    </li>
                    <li>
                    <a href="#" class="group flex items-center text-gray-600 hover:text-blue-600 transition-colors duration-200">
                        <span class="mr-2">→</span>
                        <span class="border-b border-transparent group-hover:border-blue-600">Sitemap</span>
                    </a>
                    </li>
                </ul>
                </div>

                <!-- Contact Info Section -->
                <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 tracking-wide">Contact Us</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        <p>Shri D N Institute of Computer Applications</p>
                        <p>Sardar Ganj, Anand</p>
                        <p>Gujarat, India</p>
                    </div>
                    </li>
                    <li class="flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>info@sdnica.edu</span>
                    </li>
                </ul>
                </div>

                <!-- Social Links Section -->
                <div class="space-y-4 text-center">
                <h3 class="text-lg font-bold text-gray-900 tracking-wide">Connect With Us</h3>
                <div class="flex space-x-5 justify-center">
                    <a href="#" class="transform hover:scale-110 transition-transform duration-200">
                    <span class="sr-only">Facebook</span>
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    </a>
                    <a href="#" class="transform hover:scale-110 transition-transform duration-200">
                    <span class="sr-only">Twitter</span>
                    <div class="w-10 h-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500 transition-colors duration-200">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </div>
                    </a>
                    <a href="#" class="transform hover:scale-110 transition-transform duration-200">
                    <span class="sr-only">GitHub</span>
                    <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center hover:bg-gray-800 transition-colors duration-200">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.6.113.82-.26.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.087-.744.084-.728.084-.728 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.298 24 12c0-6.627-5.373-12-12-12"/>
                        </svg>
                    </div>
                    </a>
                </div>
                </div>
            </div>

            <!-- Copyright Section -->
            <div class="border-t border-gray-200 mt-8 pt-4">
                <p class="text-center text-gray-500 text-sm">
                © 2025 Shri D N Institute of Computer Applications. All rights reserved.
                </p>
            </div>
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.querySelector('.md\\:hidden button');
        const mobileMenu = document.getElementById('mobile-menu-overlay');
        const closeMobileMenu = document.getElementById('close-mobile-menu');

        function toggleMobileMenu() {
            mobileMenu.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        mobileMenuButton.addEventListener('click', toggleMobileMenu);
        closeMobileMenu.addEventListener('click', toggleMobileMenu);
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                toggleMobileMenu();
            }
        });

        // Enhanced GSAP Animations
        const tl = gsap.timeline();

        // Navbar animation
        tl.from("nav", {
            duration: 0.8,
            y: -100,
            opacity: 0,
            ease: "power3.out"
        });

        // Header animations
        tl.from("header", {
            duration: 1,
            y: -50,
            opacity: 0,
            ease: "power3.out"
        }, "-=0.4");

        // Alert animation
        tl.from(".bg-red-50", {
            duration: 0.8,
            scale: 0.9,
            opacity: 0,
            ease: "power3.out"
        }, "-=0.6");

        // Login cards animation
        tl.from(".login-card", {
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.2,
            ease: "power3.out"
        }, "-=0.4");

        // Footer animation
        tl.from("footer", {
            duration: 0.8,
            y: 50,
            opacity: 0,
            ease: "power3.out"
        }, "-=0.4");

        // Scroll animations
        gsap.utils.toArray('.login-card').forEach(card => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: "top bottom",
                    end: "bottom top",
                    toggleActions: "play none none reverse"
                },
                y: 50,
                opacity: 0,
                duration: 0.8
            });
        });
    </script>
</body>

</html>