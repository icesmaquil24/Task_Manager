<?php
session_start();

// LOGIN
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Only Admin can access this page
if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

$page_title = 'Team - Task Management System';

include 'header.php';
?>

<div class="content">

    <h2>👥 Our Team</h2>

    <div class="team-grid">

        <div class="team-card">

            <div class="member-avatar">
                👨‍💻
            </div>

            <h3>Jherome Evangelista</h3>

            <div class="role">
                Project Manager
            </div>

            <p class="description">
                Manage the project, coordinate team, monitor progress.
            </p>

        </div>


        <div class="team-card">

            <div class="member-avatar">
                👩‍💻
            </div>

            <h3>Noel Dela Pena</h3>

            <div class="role">
                Front end Developer
            </div>

            <p class="description">
                Website interface, page layout, HTML structure.
            </p>

        </div>

        <div class="team-card">

            <div class="member-avatar">
                👩‍💻
            </div>

            <h3>Brylle Mariano</h3>

            <div class="role">
                Back end Developer
            </div>

            <p class="description">
                PHP functionality, sessions, authentication, role-based access,
                and task management features.
            </p>

        </div>


        <div class="team-card">

            <div class="member-avatar">
                👨‍💻
            </div>

            <h3>Ian Esmaquil</h3>

            <div class="role">
                Documentation, Tester
            </div>

            <p class="description">
               Project documentation, test system, identify errors.
            </p>

        </div>

    </div>

</div>

<?php
include 'footer.php';
?>