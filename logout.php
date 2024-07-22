<?php
session_start(); // Uruchomienie sesji

// Usunięcie wszystkich danych sesji
$_SESSION = array();

// Usunięcie ciasteczka sesji, jeśli jest ustawione
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zniszczenie sesji
session_destroy();

// Przekierowanie na stronę główną
header("Location: index.php");
exit;
?>
