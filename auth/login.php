<?php
session_start();
// Define the document root for your project
define('ROOT_PATH', __DIR__); // __DIR__ gets the directory of the current file (index.php)
// Now, use ROOT_PATH for includes
include '../config/db.php';
include('../includes/header.php');

if (isset($_SESSION['user_id'])) {
    header("Location: /task-productivity-tracker/index.php"); // Redirect if already logged in
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: /task-productivity-tracker/index.php");
            exit;
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Invalid username";
    }
}
?>
<body class="login-page">
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <p class="register-link">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
<?php
include '../includes/footer.php';
?>