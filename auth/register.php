<?php
session_start();
include '../config/db.php';
include '../includes/header.php';

if (isset($_SESSION['user_id'])) {
    header("Location: /task-productivity-tracker/index.php"); // Redirect if already logged in
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php"); // Redirect to login
        exit;
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<body class="register-page">
    <div class="register-container">
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="register.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="register-btn">Register</button>
        </form>
        <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
<?php
include '../includes/footer.php';
?>