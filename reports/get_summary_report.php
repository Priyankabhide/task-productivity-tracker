<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    // header("Location: ../auth/login.php");  // Removed redirection.  Return empty data.
    // exit();
     echo json_encode(array(
            'all_tasks' => 0,
            'pending_tasks' => 0,
            'completed_tasks' => 0
        ));
     exit();
}

$user_id = $_SESSION['user_id'];
// Function to get task counts (same as before)
function getTaskCounts($conn, $user_id) {
    $sql = "SELECT
                COUNT(*) as all_tasks,
                SUM(completed = 0) as pending_tasks,
                SUM(completed = 1) as completed_tasks
            FROM tasks
            WHERE user_id = '$user_id'"; // added user_id
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return array(
            'all_tasks' => 0,
            'pending_tasks' => 0,
            'completed_tasks' => 0
        );
    }
}

// Get the report data
$reportData = getTaskCounts($conn, $user_id);

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($reportData);