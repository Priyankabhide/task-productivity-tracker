<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT id FROM tasks WHERE id = '$id' AND user_id = '$user_id'"; // Add user_id check
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $delete_sql = "DELETE FROM tasks WHERE id = '$id' AND user_id = '$user_id'"; // Add user_id check
        if ($conn->query($delete_sql) === TRUE) {
            echo "<div class='alert alert-success'>Task deleted successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting task: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Task not found or you don't have permission to delete it.</div>";
    }
}
echo "<a href='read.php' class='btn btn-secondary'>View Tasks</a>";

include '../includes/footer.php';
?>