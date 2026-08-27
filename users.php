<?php
session_start();

// Make sure the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Only Admin can access this page
if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Create tasks array if it does not exist
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// List of users
$users = [
    'admin' => 'Admin',
    'student1' => 'Student',
    'student2' => 'Student'
];

// Count tasks assigned to each user
$task_counts = [];

foreach ($users as $username => $role) {

    $task_counts[$username] = 0;

    foreach ($_SESSION['tasks'] as $task) {

        if ($task['assigned_to'] === $username) {
            $task_counts[$username]++;
        }
    }
}

$page_title = 'Users - Task Management System';

include 'header.php';
?>

<div class="content">

    <h2>👥 Users</h2>

    <table class="task-table">

        <thead>

            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Role</th>
                <th>Task Count</th>
            </tr>

        </thead>

        <tbody>

            <?php $number = 1; ?>

            <?php foreach ($users as $username => $role): ?>

                <tr>

                    <td>
                        <?php echo $number; ?>
                    </td>

                    <td>
                        <strong>
                            <?php echo htmlspecialchars($username); ?>
                        </strong>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($role); ?>
                    </td>

                    <td>
                        <?php echo $task_counts[$username]; ?>
                    </td>

                </tr>

                <?php $number++; ?>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

<?php
include 'footer.php';
?>