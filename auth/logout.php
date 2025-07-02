<?php
session_start();
session_destroy();
header("Location: /task-productivity-tracker/index.php");
exit;
?>
