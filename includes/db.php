<?php
$host = "localhost";
$user = "root";   // default in XAMPP
$pass = "";       // leave empty in XAMPP unless you set a password
$dbname = "student_db"; // change to your DB name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
