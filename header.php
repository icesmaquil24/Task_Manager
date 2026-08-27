<?php
// This file should be included at the top of every page
// $page_title should be set before including this file
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Task Manager'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <h1>📋 Task Manager</h1>
            </div>
            <div class="user-info">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <span>👋 Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</span>
                    <span class="role-badge <?php echo $_SESSION['role']; ?>">
                        <?php echo ucfirst($_SESSION['role']); ?>
                    </span>
                    <a href="logout.php" class="btn-logout">🚪 Logout</a>
                <?php endif; ?>
            </div>
        </header>

        <nav class="nav-menu">
            <a href="dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'class="active"' : ''; ?>>🏠 Dashboard</a>
            <a href="view_tasks.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'view_tasks.php') ? 'class="active"' : ''; ?>>📋 View Tasks</a>
            <a href="add_task.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'add_task.php') ? 'class="active"' : ''; ?>>➕ Add Task</a>

            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="about.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'class="active"' : ''; ?>>ℹ️ About</a>
                <a href="team.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'team.php') ? 'class="active"' : ''; ?>>👥 Team</a>
                <a href="users.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'class="active"' : ''; ?>>👥 Users</a>
            <?php endif; ?>
        </nav>