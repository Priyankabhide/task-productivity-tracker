<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); // Redirect if not logged in
    exit();
}

echo "<h2 style='color:white; font-weight:bold; text-align:center; margin-bottom:20px'>Task List</h2>";

$user_id = $_SESSION['user_id']; // Get the user ID from the session
$sql = "SELECT id, name, description, completed, priority, start_time, end_time FROM tasks WHERE user_id = '$user_id'"; // Add fields
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-striped'>";
    // Added inline style to the <th> for Actions column
    echo "<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Completed</th><th>Priority</th><th>Start Time</th><th>End Time</th><th style='min-width: 280px;'>Actions</th></tr></thead>"; 
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . ($row["completed"] ? "Yes" : "No") . "</td>";
        echo "<td>" . $row["priority"] . "</td>";
        echo "<td>" . ($row["start_time"] ?? "N/A") . "</td>"; // Use ?? for null coalescing
        echo "<td>" . ($row["end_time"] ?? "N/A") . "</td>";
        // Modified inline style for the <td> and added an inner div for flex layout
        echo "<td style='white-space: nowrap;'>"; 
        echo "<div style='display: flex; gap: 5px; align-items: center; width: 100%;'>"; // New div with flex and 100% width
        echo "<a href='update.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Update</a>";
        echo "<a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
        if (!$row["completed"]) {
            echo "<form method='post' action='read.php' style='display:inline-flex; margin:0;'>"; // Changed to inline-flex and removed margin
            echo "<input type='hidden' name='complete_id' value='" . $row["id"] . "'>";
            echo "<button type='submit' class='btn btn-success btn-sm'>Mark as Completed</button>";
            echo "</form>";
        }
        echo "</div>"; // Close the new div
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p style='color:#fff'>No tasks found for this user.</p>"; // Inform the user
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete_id'])) {
    $complete_id = $_POST['complete_id'];
    $update_sql = "UPDATE tasks SET completed = 1, completion_time = NOW() WHERE id = '$complete_id' AND user_id = '$user_id'"; // Add user_id check
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>window.location.href='read.php';</script>"; // Refresh page
        exit();
    } else {
        echo "Error updating task: " . $conn->error;
    }
}

// echo "<a href='../index.php' class='btn btn-success mt-3'>Go to Home</a>";
echo "<a href='../index.php' class='btn btn-outline-light'>Go to Home</a>";

include '../includes/footer.php';
?>
