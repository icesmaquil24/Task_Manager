<?php
session_start();

// If already logged in, go to dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Hardcoded accounts required by the exam
    $users = [
        'admin' => [
            'password' => 'admin123',
            'role' => 'admin'
        ],
        'student1' => [
            'password' => 'pass123',
            'role' => 'student'
        ],
        'student2' => [
            'password' => 'pass123',
            'role' => 'student'
        ]
    ];

    if (isset($users[$username]) && $users[$username]['password'] === $password) {

        // Save login information in session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];
        $_SESSION['logged_in'] = true;

        // Create tasks array if it does not exist yet
        if (!isset($_SESSION['tasks'])) {
            $_SESSION['tasks'] = [];
        }

        header('Location: dashboard.php');
        exit();

    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<?php $page_title = 'Login - Task Management System'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-container">
    <div class="login-box">

        <div class="login-header">
            <div class="logo-container">
                <div style="font-size: 60px;">📋</div>
            </div>

            <h1>Task Manager</h1>
            <p class="subtitle">Web Systems and Technologies I</p>
            <p class="university-name">ITCC1023</p>
        </div>

        <?php if ($error !== ''): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    autocomplete="username"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn-login">
                🔐 Login
            </button>

            <button type="reset" class="btn-reset">
                Clear
            </button>

        </form>

        <div class="login-info">
            <span class="demo-label">Demo Accounts</span>
            <strong>Admin:</strong> admin / admin123<br>
            <strong>Student:</strong> student1 / pass123<br>
            <strong>Student:</strong> student2 / pass123
        </div>

    </div>
</div>

</body>
</html>