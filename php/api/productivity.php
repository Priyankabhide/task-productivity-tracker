<?php
include '../../config/db.php';

// Function to get productivity data
function getProductivity($conn, $user_id) {
    // Get total number of tasks for the user
    $sql_total = "SELECT COUNT(*) as total_tasks FROM tasks WHERE user_id = '$user_id'";
    $result_total = $conn->query($sql_total);
    $total_tasks = ($result_total->num_rows > 0) ? $result_total->fetch_assoc()['total_tasks'] : 0;

    // Get number of completed tasks for the user
    $sql_completed = "SELECT COUNT(*) as completed_tasks FROM tasks WHERE completed = 1 AND user_id = '$user_id'";
    $result_completed = $conn->query($sql_completed);
    $completed_tasks = ($result_completed->num_rows > 0) ? $result_completed->fetch_assoc()['completed_tasks'] : 0;

    // Calculate productivity percentage
    $productivity_percentage = ($total_tasks > 0) ? round(($completed_tasks / $total_tasks) * 100, 2) : 0;

    // Get completion times of completed tasks for the user
    $sql_completion_times = "SELECT t.name, t.completion_time FROM tasks t WHERE t.completed = 1 AND t.completion_time IS NOT NULL AND t.user_id = '$user_id' ORDER BY t.completion_time DESC";
    $result_completion_times = $conn->query($sql_completion_times);
    $completion_times = [];
    if ($result_completion_times->num_rows > 0) {
        while ($row = $result_completion_times->fetch_assoc()) {
            $completion_times[] = array(
                'name' => $row['name'],
                'completion_time' => $row['completion_time']
            );
        }
    }

    // Return the data
    return array(
        'totalTasks' => $total_tasks,
        'completedTasks' => $completed_tasks,
        'productivityPercentage' => $productivity_percentage,
        'completionTimes' => $completion_times
    );
}

// Get the user ID from the session
session_start(); // Start the session to access $_SESSION
if (!isset($_SESSION['user_id'])) {
    //  header("Location: ../auth/login.php"); // removed redirection.  Return empty JSON
    //  exit();
     echo json_encode(array(  // Return empty array
            'totalTasks' => 0,
            'completedTasks' => 0,
            'productivityPercentage' => 0,
             'completionTimes' => []
        ));
     exit();
}
$user_id = $_SESSION['user_id'];

// Get productivity data
$productivityData = getProductivity($conn, $user_id); // Pass user ID

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($productivityData);
?>
