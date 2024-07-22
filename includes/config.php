<?php
// Parametry połączenia z bazą danych
$dbHost = 'localhost';
$dbUsername = 'root'; // Zmień na swojego użytkownika bazy danych
$dbPassword = ''; // Zmień na swoje hasło bazy danych
$dbName = 'blog_database';

// Tworzenie połączenia z bazą danych
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}
?>
