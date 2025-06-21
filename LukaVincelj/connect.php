<?php
$servername = "localhost";
$username = "root";
$password = "root";
$basename = "vijesti_db";

$conn = new mysqli($servername, $username, $password, $basename);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
