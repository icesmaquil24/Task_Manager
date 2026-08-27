<?php
session_start();

// Make sure the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Create tasks array if it does not exist
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Calculate statistics
$total_tasks = 0;
$pending_tasks = 0;
$completed_tasks = 0;

foreach ($_SESSION['tasks'] as $task) {

    // Admin sees statistics for ALL tasks
    // Student sees statistics for their OWN tasks
    if ($role === 'admin' || $task['assigned_to'] === $username) {

        $total_tasks++;

        if ($task['status'] === 'completed') {
            $completed_tasks++;
        } else {
            $pending_tasks++;
        }
    }
}

$page_title = 'Dashboard - Task Management System';

include 'header.php';
?>

<div class="content">

    <h2>🏠 Dashboard</h2>

    <?php if ($role === 'admin'): ?>

        <div class="role-notice admin-notice">
            <strong>Welcome, <?php echo htmlspecialchars($username); ?>!</strong>
            You are logged in as an Administrator.
            You have full access to the Task Management System.
        </div>

    <?php else: ?>

        <div class="role-notice student-notice">
            <strong>Welcome, <?php echo htmlspecialchars($username); ?>!</strong>
            You are logged in as a Student.
            You can manage and complete your own tasks.
        </div>

    <?php endif; ?>


    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-number">
                <?php echo $total_tasks; ?>
            </div>
            <div class="stat-label">
                <?php echo ($role === 'admin') ? 'All Tasks' : 'My Tasks'; ?>
            </div>
        </div>


        <div class="stat-card pending">
            <div class="stat-number">
                <?php echo $pending_tasks; ?>
            </div>
            <div class="stat-label">
                Pending Tasks
            </div>
        </div>


        <div class="stat-card completed">
            <div class="stat-number">
                <?php echo $completed_tasks; ?>
            </div>
            <div class="stat-label">
                Completed Tasks
            </div>
        </div>

    </div>


 //asdsadsa   

</div>

<?php
include 'footer.php';
?>