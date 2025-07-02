<?php
session_start();
// Define the document root for your project
define('ROOT_PATH', __DIR__);

// Now, use ROOT_PATH for includes
include(ROOT_PATH . '/config/db.php');
include(ROOT_PATH . '/includes/header.php');
?>
<div class="container landing-page">
    <div class="left-section">
        <img src="images/homeimg.jpg" width="500px" height="500px" alt="Task Management App" class="app-image">
    </div>
    <div class="right-section">
        <div class="header-info">
            <h1>Welcome to TaskTracker</h1>
            <p>Organize your tasks, boost your productivity, and manage your time effectively with our intuitive task management application.</p>
        </div>
        <div class="options-container">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class='alert alert-success' role='alert'>Welcome, <?php echo $_SESSION['username']; ?>!</div>
                <!-- <p class='lead'>This is your personalized dashboard. You can manage your tasks and view reports.</p> -->
                <a href="/task-productivity-tracker/dashboard.php" class="login-btn">Go to Dashboard</a>
            <?php else: ?>
                <div class='alert alert-info' role='alert'>Welcome, Guest!</div>
                <p class='lead'>Please login or register to use the task manager.</p>
                <div class="button-group">
                    <a href="/task-productivity-tracker/auth/login.php" id="login-btn">Login</a>
                    <a href="/task-productivity-tracker/auth/register.php" id="register-btn">Register</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
include(ROOT_PATH . '/includes/footer.php');
?>