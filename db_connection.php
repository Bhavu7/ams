<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_management";

$conn = new mysqli($servername, $username, $password, $dbname);

$message = '';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$message =  "Connected successfully";
?>
