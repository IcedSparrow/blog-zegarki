<?php
// Start the session
session_start();

// Załącz plik konfiguracyjny bazy danych
require_once 'includes/config.php';

// Inicjalizacja zmiennej błędu
$error = '';

// Sprawdź, czy formularz został wysłany
if (isset($_POST['submit'])) {
    // Przypisanie i oczyszczenie danych formularza
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Sprawdzenie, czy użytkownik o podanej nazwie lub email już istnieje
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $error = 'Użytkownik o podanej nazwie użytkownika lub email już istnieje.';
    } else {
        // Dodanie użytkownika do bazy
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $passwordHash);
        if ($stmt->execute()) {
            // Przekierowanie do strony logowania po pomyślnej rejestracji
            header("Location: login.php");
            exit;
        } else {
            $error = 'Wystąpił błąd podczas rejestracji. Proszę spróbować ponownie.';
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja - Twój Blog</title>
    <style>
/* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    width: 100%;
    height: 100%;
}

header, footer {
    width: 100%;
    background-color: transparent; /* Przezroczyste tło */
    color: white;
    text-align: center;
    padding: 10px 0;
}

/* Pozostałe style */
body {
    background-image: url("img/back-ground-reg.webp");
    background-size: 100%;
    font-family: "Roboto", sans-serif;
}

.login-page {
    padding: 8% 0 0;
    margin: auto;
}


.form {
    background: rgba(255, 255, 255, 0.5); /* Białe tło z 50% przezroczystości */
    max-width: 360px;
    margin: 0 auto 100px;
    padding: 45px;
    text-align: center;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}


.form input {
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    font-size: 14px;
}

.form button {
    text-transform: uppercase;
    outline: 0;
    background: #4CAF50;
    width: 100%;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
}

.error {
    color: #FF0000; /* Kolor komunikatu o błędzie */
    margin-bottom: 10px;
}

.reg {
    text-align: center;
    color: white;
}

/* Styl dla nawigacji */
nav {
    background-color: transparent; /* Przezroczyste tło */
    padding: 10px 0;
}

nav ul {
    list-style: none;
    text-align: center;
    padding: 0;
    margin: 0;
}

nav ul li {
    display: inline-block;
}

nav ul li a {
    display: block;
    padding: 15px 20px;
    text-decoration: none;
    color: white;
    font-size: 16px;
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
}

nav ul li a:hover,
nav ul li a:focus {
    background-color: #555; /* Kolor tła po najechaniu */
    color: #FFF; /* Kolor tekstu po najechaniu */
}

    </style>
</head>
<body>
<header>
    <h1>Rejestracja</h1>
    <nav>
        <ul>
            <li><a href="index.php">Strona główna</a></li>
            <li><a href="about.php">O mnie</a></li>
            <li><a href="contact.php">Kontakt</a></li>
            <?php if (isset($_SESSION['userid'])): ?>
            <?php else: ?>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="login-page">
    <h2 class="reg">Rejestracja</h2>
    <?php if ($error != ''): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>
    <form action="register.php" method="post" class="form">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit" name="submit">Zarejestruj się</button>
    </form>
</main>
</body>
</html>
