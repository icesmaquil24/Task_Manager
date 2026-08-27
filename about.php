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

$page_title = 'About - Task Management System';

include 'header.php';
?>

<div class="content">

    <h2>ℹ️ About the Project</h2>

    <div class="about-container">

        <div class="about-section">

            <h3>📋 Task Management System</h3>

            <p>
                The Task Management System is a web-based project
                developed for ITCC1023 - Web Systems and Technologies I.
                It allows users to manage tasks according to their
                assigned role.
            </p>

        </div>


        <div class="about-section">

            <h3>🎯 Project Purpose</h3>

            <p>
                The purpose of this system is to demonstrate basic
                web development concepts including PHP sessions,
                user authentication, role-based access control,
                task management, and reusable PHP components.
            </p>

        </div>


        <div class="about-section">

            <h3>👥 User Roles</h3>

            <ul>
                <li><strong>Administrator:</strong> Has full access to the system.</li>
                <li><strong>Student:</strong> Can manage their own tasks.</li>
            </ul>

        </div>


        <div class="about-section">

            <h3>🛠️ Technologies Used</h3>

            <ul>
                <li>HTML</li>
                <li>CSS</li>
                <li>PHP</li>
                <li>PHP Sessions</li>
                <li>XAMPP / Apache</li>
            </ul>

        </div>

    </div>

</div>

<?php
include 'footer.php';
?>