<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

echo "<h2 style='color:white; font-weight:bold; text-align:center; margin-bottom:20px'>All Tasks</h2>";
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = '$user_id'"; // Filter by user_id
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>Name</th><th>Description</th><th>Completed</th><th>Priority</th><th>Start Time</th><th>End Time</th></tr></thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . ($row["completed"] ? "Yes" : "No") . "</td>";
         echo "<td>" . $row["priority"] . "</td>";
        echo "<td>" . ($row["start_time"] ?? "N/A") . "</td>";
        echo "<td>" . ($row["end_time"] ?? "N/A") . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p style='color:#fff;'>No tasks found for this user.</p>";
}

echo "<a href='index.php' class='btn btn-outline-light' mt-3'>Back to Reports</a>";

include '../includes/footer.php';
?>