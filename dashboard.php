<?php
session_start();
// Define the document root for your project
define('ROOT_PATH', __DIR__); // __DIR__ gets the directory of the current file (index.php)
include(ROOT_PATH . '/config/db.php');
include(ROOT_PATH . '/includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php"); // Redirect if not logged in
    exit();
}
?>
<div class="container">
        <div class="options-container">
                    <?php if (isset($_SESSION['user_id'])): ?>
                         <p id='lead'>This is your personalized dashboard. You can manage your tasks and view reports.</p>
                         <div class='card mb-4'>
                             <div class='card-body'>
                                <h2 class='card-title'>Manage Tasks</h2>
                                 <p class='card-text'>
                                    <a href='/task-productivity-tracker/tasks/create.php' class='btn btn-primary'>Create New Task</a> 
                                     <a href='/task-productivity-tracker/tasks/read.php' class='btn btn-secondary'>View All Tasks</a>
                                    </p>
                            </div>
                        </div>
                            <div class='card mb-4'>
                                <div class='card-body'>
                                    <h2 class='card-title'>Task Reports</h2>
                                    <p class='card-text'>
                                        <a href='/task-productivity-tracker/reports/index.php' class='btn btn-info'>View Summary Report</a> 
                                        <a href='/task-productivity-tracker/reports/all-tasks.php' class='btn btn-outline-info'>All Tasks</a> 
                                        <a href='/task-productivity-tracker/reports/completed.php' class='btn btn-outline-success'>Completed Tasks</a> 
                                        <a href='/task-productivity-tracker/reports/pending.php' class='btn btn-outline-warning'>Pending Tasks</a>
                                    </p>
                                </div>
                            </div>
                            <div class='card mb-4' id='productivitySummary'>
                                <div class='card-body'>
                                    <h2 class='card-title'>Productivity Summary</h2>
                                    <ul class='list-group' id='productivityList'>
                                        <li class='list-group-item'>Loading...</li> 
                                    </ul>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class='alert alert-info' role='alert'>Welcome, Guest!</div>
                            <?php endif; ?>
        </div>
</div>
                    <?php
                    include(ROOT_PATH . '/includes/footer.php');
                    ?>