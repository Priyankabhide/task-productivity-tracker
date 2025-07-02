<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Function to get task counts
function getTaskCounts($conn, $user_id) {
    $sql = "SELECT
                COUNT(*) as all_tasks,
                SUM(completed = 0) as pending_tasks,
                SUM(completed = 1) as completed_tasks,
                AVG(TIMESTAMPDIFF(SECOND, start_time, completion_time)) as avg_completion_time
            FROM tasks
            WHERE user_id = '$user_id'"; // Add user_id to where clause
    try {
        $result = $conn->query($sql);
         if ($result === false) {
            throw new Exception("Query failed: " . $conn->error);
        }
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
             $avg_completion_time = intval($data['avg_completion_time']);
            return array(
                'all_tasks' => $data['all_tasks'],
                'pending_tasks' => $data['pending_tasks'],
                'completed_tasks' => $data['completed_tasks'],
                'avg_completion_time' => $avg_completion_time
            );
        } else {
            return array(
                'all_tasks' => 0,
                'pending_tasks' => 0,
                'completed_tasks' => 0,
                'avg_completion_time' => 0
            );
        }
    } catch (Exception $e) {
        error_log("Error in getTaskCounts: " . $e->getMessage()); // Log the error
        return array(  // Return default values on error to prevent further errors
                'all_tasks' => 0,
                'pending_tasks' => 0,
                'completed_tasks' => 0,
                'avg_completion_time' => 0
            );
    }
}

// Attempt to get the task counts.
try {
    $taskCounts = getTaskCounts($conn, $user_id);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();  // show the error.
    include '../includes/footer.php';
    exit();
}

echo "<h2 style='color:white; font-weight:bold; text-align:center; margin-bottom:20px'>Task Reports</h2>";
echo "<div class='card mb-4'>
        <div class='card-body'>
            <h3 class='card-title'>View Summary Report</h3>
            <p class='card-text'>All Tasks: " . $taskCounts['all_tasks'] . "</p>
            <p class='card-text'>Pending Tasks: " . $taskCounts['pending_tasks'] . "</p>
            <p class='card-text'>Completed Tasks: " . $taskCounts['completed_tasks'] . "</p>";
if($taskCounts['avg_completion_time'] > 0){
     echo "<p class='card-text'>Average Completion Time: " . gmdate("H:i:s", $taskCounts['avg_completion_time']) . "</p>";
}
else{
     echo "<p class='card-text'>Average Completion Time: N/A</p>";
}
           
echo "</div>
       </div>";

echo "<div class='card'>
        <div class='card-body'>
            <h3 class='card-title'>Task Details</h3>
            <p class='card-text'><a href='all-tasks.php'>View All Tasks</a></p>
            <p class='card-text'><a href='completed.php'>View Completed Tasks</a></p>
            <p class='card-text'><a href='pending.php'>View Pending Tasks</a></p>
        </div>
       </div>";

include '../includes/footer.php';
?>