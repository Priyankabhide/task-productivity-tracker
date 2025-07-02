<?php
//This file might be the same as register.php
session_start();
include '/task-productivity-tracker/config/db.php';
include '/task-productivity-tracker/includes/header.php';

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
<h2>Sign Up</h2>
<?php if (isset($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="post" action="signup.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br><br>
     <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Sign Up">
</form>
<p>Already have an account? <a href="login.php">Login</a></p>
<?php
include '/task-productivity-tracker/includes/footer.php';
?>
