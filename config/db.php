<?php
$host = "localhost";
$username = "root"; // Change this
$password = "";     // Change this
$database = "task_tracker"; // Change this

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
