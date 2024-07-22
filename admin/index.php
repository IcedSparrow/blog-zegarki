<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administracyjny</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="dashboard">
        <h2>Dashboard</h2>
        <nav>
            <ul>
                <li><a href="manage-posts.php">Zarządzanie wpisami</a></li>
                <!-- Tutaj więcej linków do innych sekcji panelu -->
            </ul>
        </nav>
    </div>
</body>
</html>
