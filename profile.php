<?php
session_start();
require_once 'includes/config.php'; // Dołącz plik konfiguracyjny bazy danych

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['userid'];
$message = '';

// Obsługa zmiany hasła
if (isset($_POST['changePassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword !== $confirmPassword) {
        $message = 'Nowe hasła się nie zgadzają.';
    } else {
        // Sprawdź aktualne hasło
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($currentPassword, $user['password'])) {
            // Aktualizuj hasło
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("si", $newPasswordHash, $userId);
            if ($updateStmt->execute()) {
                $message = 'Hasło zostało zmienione.';
            } else {
                $message = 'Wystąpił błąd podczas zmiany hasła.';
            }
        } else {
            $message = 'Aktualne hasło jest nieprawidłowe.';
        }
    }
}

// Pobierz informacje o użytkowniku
$query = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mój Profil</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url("img/profil.webp");
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Zapewnia, że stopka będzie na dole strony */
}

main {
    flex-grow: 1; /* Rozciąga główny kontener, aby zajmował całą dostępną przestrzeń */
    max-width: 600px;
    margin: 20px auto;
    background-color: rgba(255, 255, 255, 0.5); /* Zmienione tło formularza na 50% przezroczyste */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    color: black;
}


/* Pozostała część kodu CSS bez zmian */
h2 {
    margin-top: 0;
    color: black;
}

p {
    color: black;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

footer {
    text-align: center;
    color: #666;
    margin-top: auto; /* Pozycjonuje stopkę na dole strony */
}

footer p {
    margin: 0;
}
header{
    background-color: #333;
}

    </style>
</head>
<body>
<header>
    <h1>Mój Profil!</h1>
    <nav>
        <ul>
            <li><a href="index.php">Strona główna</a></li>
            <li><a href="about.php">O mnie</a></li>
            <li><a href="contact.php">Kontakt</a></li>
            <?php if (isset($_SESSION['userid'])): ?>
                <li><a href="profile.php">Mój profil</a></li>
                <li><a href="logout.php">Wyloguj</a></li>
            <?php else: ?>
                <li><a href="login.php">Logowanie</a></li>
                <li><a href="register.php">Rejestracja</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
    <h2>Mój Profil</h2>
    <p>Nazwa użytkownika: <?= htmlspecialchars($user['username']); ?></p>
    <p>Email: <?= htmlspecialchars($user['email']); ?></p>

    <h3>Zmień hasło</h3>
    <?php if ($message !== ''): ?>
        <p><?= $message; ?></p>
    <?php endif; ?>
    <form action="profile.php" method="post">
        <label for="currentPassword">Aktualne hasło:</label>
        <input type="password" id="currentPassword" name="currentPassword" required>
        <label for="newPassword">Nowe hasło:</label>
        <input type="password" id="newPassword" name="newPassword" required>
        <label for="confirmPassword">Potwierdź nowe hasło:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <button type="submit" name="changePassword">Zmień hasło</button>
    </form>
</main>

<footer>
        <p>&copy; 2024 ZegarkiDawida. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
