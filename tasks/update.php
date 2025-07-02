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

    $sql = "SELECT id, name, description, priority, start_time, end_time FROM tasks WHERE id = '$id' AND user_id = '$user_id'"; // Add fields
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $priority = $row['priority'];
        $start_time = $row['start_time'];
        $end_time = $row['end_time'];
    } else {
        echo "<div class='alert alert-danger'>Task not found or you don't have permission to edit it.</div>";
        echo "<a href='read.php' class='btn btn-secondary'>View Tasks</a>";
        include '../includes/footer.php';
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    $priority = $_POST['priority'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "UPDATE tasks SET name = '$name', description = '$description', priority = '$priority', start_time = '$start_time', end_time = '$end_time' WHERE id = '$id' AND user_id = '$user_id'"; // Add fields

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Task updated successfully</div>";
        echo "<a href='read.php' class='btn btn-secondary'>View Tasks</a>";
    } else {
        echo "<div class='alert alert-danger'>Error updating task: " . $conn->error . "</div>";
    }
}
?>

<body class="update-task-page"> <div class="update-task-container"> <h2>Update Task</h2>
        <form method="post" action="update.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Priority:</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="p1" <?php if ($priority == 'p1') echo 'selected'; ?>>High</option>
                    <option value="p2" <?php if ($priority == 'p2') echo 'selected'; ?>>Medium</option>
                    <option value="p3" <?php if ($priority == 'p3') echo 'selected'; ?>>Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="<?php echo $start_time; ?>">
            </div>
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="<?php echo $end_time; ?>">
            </div>
            <button type="submit" class="update-task-btn">Update Task</button> </form>
    </div>
</body>

<?php
include '../includes/footer.php';
?>