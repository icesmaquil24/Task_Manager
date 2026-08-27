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

/*
 * Handle task actions
 * complete = mark a task as completed
 * delete   = delete a task (admin only)
 */

if (isset($_GET['action'], $_GET['id'])) {

    $action = $_GET['action'];
    $task_id = (int) $_GET['id'];

    // Make sure the task exists
    if (isset($_SESSION['tasks'][$task_id])) {

        $task = $_SESSION['tasks'][$task_id];

        // COMPLETE TASK
        if ($action === 'complete') {

            // Admin can complete any task
            // Student can only complete their own task
            if ($role === 'admin' || $task['assigned_to'] === $username) {
                $_SESSION['tasks'][$task_id]['status'] = 'completed';
            }
        }

        // DELETE TASK
        elseif ($action === 'delete') {

            // Only admin can delete
            if ($role === 'admin') {
                unset($_SESSION['tasks'][$task_id]);

                // Re-number the array
                $_SESSION['tasks'] = array_values($_SESSION['tasks']);
            }
        }
    }

    // Refresh the page after the action
    header('Location: view_tasks.php');
    exit();
}

$page_title = 'View Tasks - Task Management System';

include 'header.php';
?>

<div class="content">

    <h2>📋 View Tasks</h2>

    <?php
    // Find tasks visible to this user
    $visible_tasks = [];

    foreach ($_SESSION['tasks'] as $id => $task) {

        // Admin sees everything
        // Student sees only tasks assigned to themselves
        if ($role === 'admin' || $task['assigned_to'] === $username) {

            $visible_tasks[$id] = $task;
        }
    }
    ?>


    <?php if (empty($visible_tasks)): ?>

        <div class="empty-state">

            <p>📭 No tasks found.</p>

            <a href="add_task.php" class="btn-primary">
                ➕ Add Your First Task
            </a>

        </div>

    <?php else: ?>

        <table class="task-table">

            <thead>
                <tr>

                    <th>#</th>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Assigned To</th>

                    <?php if ($role === 'admin'): ?>
                        <th>Created By</th>
                    <?php endif; ?>

                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>

            <tbody>

                <?php foreach ($visible_tasks as $id => $task): ?>

                    <tr>

                        <td>
                            <?php echo $id + 1; ?>
                        </td>

                        <td>
                            <strong>
                                <?php echo htmlspecialchars($task['title']); ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($task['description']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($task['assigned_to']); ?>
                        </td>

                        <?php if ($role === 'admin'): ?>

                            <td>
                                <?php echo htmlspecialchars($task['created_by']); ?>
                            </td>

                        <?php endif; ?>


                        <td>

                            <?php if ($task['status'] === 'completed'): ?>

                                <span class="status-badge complete">
                                    ✓ Completed
                                </span>

                            <?php else: ?>

                                <span class="status-badge pending">
                                    ⏳ Pending
                                </span>

                            <?php endif; ?>

                        </td>


                        <td>

                            <?php if ($task['status'] !== 'completed'): ?>

                                <a
                                    href="view_tasks.php?action=complete&id=<?php echo $id; ?>"
                                    class="btn-complete"
                                >
                                    ✓ Complete
                                </a>

                            <?php else: ?>

                                <span class="completed-text">
                                    ✓ Done
                                </span>

                            <?php endif; ?>


                            <?php if ($role === 'admin'): ?>

                                <a
                                    href="view_tasks.php?action=delete&id=<?php echo $id; ?>"
                                    class="btn-delete"
                                    onclick="return confirm('Are you sure you want to delete this task?');"
                                >
                                    🗑 Delete
                                </a>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>

<?php
include 'footer.php';
?>