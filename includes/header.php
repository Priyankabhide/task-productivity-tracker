<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task and Productivity Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/task-productivity-tracker/css/dashboard.css">
    <link rel="stylesheet" href="/task-productivity-tracker/css/style.css">
      <link rel="stylesheet" href="/task-productivity-tracker/css/header.css">
    <link rel="stylesheet" href="/task-productivity-tracker/css/register.css">
    <link rel="stylesheet" href="/task-productivity-tracker/css/login.css">
    <link rel="stylesheet" href="/task-productivity-tracker/css/create.css">
    <link rel="stylesheet" href="/task-productivity-tracker/css/update.css">

    <script src="/task-productivity-tracker/js/script.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<header>
<div class="topnav">
     <a href="/task-productivity-tracker/index.php"><span id="logo">TaskTracker<img src="/task-productivity-tracker/images/logo.webp" alt="Task Tracker Logo" style="max-height: 50px;"></span></a>
    <a class="nav-link active" href="/task-productivity-tracker/index.php">Home</a>
     <a class="nav-link" href="/task-productivity-tracker/dashboard.php">Dashboard</a>
    <a class="nav-link" href="/task-productivity-tracker/tasks/read.php">Tasks</a>
    <a class="nav-link" href="/task-productivity-tracker/reports/index.php">Reports</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a class="nav-link" href="/task-productivity-tracker/tasks/create.php">Create Task</a>
        <a class="nav-link" href="/task-productivity-tracker/index.php" id="checkProductivity">Check Productivity</a>
        <div class="topnav-right">

            <a class="nav-link" href="/task-productivity-tracker/auth/logout.php"> <img src="/task-productivity-tracker/images/logout.webp" alt="" style="max-height: 50px; max-width:38px">Logout</a>
        </div>  
    <?php else: ?>
  <div class="topnav-right">
    <a class="nav-link" href="/task-productivity-tracker/auth/login.php">Login</a>
    <a class="nav-link" href="/task-productivity-tracker/auth/register.php">Register</a>
    </div>
     <?php endif; ?>
</div>

    </header>
    <main class="container py-4 flex-grow-1">