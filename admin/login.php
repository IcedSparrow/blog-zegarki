<?php
session_start();
require_once('../includes/config.php');

if (isset($_POST['submit'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT id, role FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userid'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        header('Location: index.php');
    } else {
        echo "<script>alert('Niepoprawne dane logowania');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administracyjny - Logowanie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-form">
        <h2>Logowanie</h2>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Nazwa użytkownika" required>
            <input type="password" name="password" placeholder="Hasło" required>
            <button type="submit" name="submit">Zaloguj się</button>
        </form>
    </div>
</body>
</html>
