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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Admin chooses who receives the task
    // Student is automatically assigned to themselves
    if ($role === 'admin') {
        $assigned_to = $_POST['assigned_to'] ?? '';
    } else {
        $assigned_to = $username;
    }

    // Validate the form
    if ($title === '') {

        $error = 'Please enter a task title.';

    } elseif ($description === '') {

        $error = 'Please enter a task description.';

    } elseif ($assigned_to === '') {

        $error = 'Please select a user to assign the task to.';

    } else {

        // Create the new task
        $new_task = [
            'title' => $title,
            'description' => $description,
            'assigned_to' => $assigned_to,
            'created_by' => $username,
            'status' => 'pending'
        ];

        // Store task in the session
        $_SESSION['tasks'][] = $new_task;

        $success = 'Task added successfully!';

        // Clear form values
        $title = '';
        $description = '';
    }
}

$page_title = 'Add Task - Task Management System';

include 'header.php';
?>

<div class="content">

    <h2>➕ Add Task</h2>

    <?php if ($success !== ''): ?>

        <div class="success-message">
            <?php echo htmlspecialchars($success); ?>

            <br><br>

            <a href="view_tasks.php" class="btn-primary">
                📋 View Tasks
            </a>
        </div>

    <?php endif; ?>


    <?php if ($error !== ''): ?>

        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <form method="POST" action="" class="task-form">

        <div class="form-group">

            <label for="title">
                Task Title
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="<?php echo htmlspecialchars($title ?? ''); ?>"
                placeholder="Enter task title"
                required
            >

        </div>


        <div class="form-group">

            <label for="description">
                Description
            </label>

            <textarea
                id="description"
                name="description"
                rows="5"
                placeholder="Enter task description"
                required
            ><?php echo htmlspecialchars($description ?? ''); ?></textarea>

        </div>


        <?php if ($role === 'admin'): ?>

            <div class="form-group">

                <label for="assigned_to">
                    Assign Task To
                </label>

                <select
                    id="assigned_to"
                    name="assigned_to"
                    required
                >

                    <option value="">
                        -- Select User --
                    </option>

                    <option value="admin">
                        admin
                    </option>

                    <option value="student1">
                        student1
                    </option>

                    <option value="student2">
                        student2
                    </option>

                </select>

            </div>

        <?php else: ?>

            <div class="role-notice student-notice">

                <strong>Assigned To:</strong>
                <?php echo htmlspecialchars($username); ?>

                <br>

                Your tasks are automatically assigned to you.

            </div>

        <?php endif; ?>


        <button type="submit" class="btn-submit">
            ➕ Add Task
        </button>

        <button type="reset" class="btn-reset-form">
            Clear
        </button>

    </form>

</div>

<?php
include 'footer.php';
?>