<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); // Redirect if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    $priority = $_POST['priority'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO tasks (name, description, user_id, completed, completion_time, priority, start_time, end_time)
            VALUES ('$name', '$description', '$user_id', 0, NULL, '$priority', '$start_time', '$end_time')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Task created successfully</div>";
        echo "<a href='read.php' class='btn btn-secondary'>View Tasks</a>";
    } else {
        echo "<div class='alert alert-danger'>Error creating task: " . $conn->error . "</div>";
    }
}
?>
<body class="create-task-page">
    <div class="create-task-container">
        <h2>Create Task</h2>
        <form method="post" action="create.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Priority:</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="" disabled selected>Select Priority</option> <option value="p1">High</option>
                    <option value="p2">Medium</option>
                    <option value="p3">Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="datetime-local" class="form-control" id="start_time" name="start_time">
            </div>
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="datetime-local" class="form-control" id="end_time" name="end_time">
            </div>
            <button type="submit" class="create-task-btn">Create Task</button>
        </form>
    </div>
</body>
<?php
include '../includes/footer.php';
?>
