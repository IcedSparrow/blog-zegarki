<?php
session_start();
require_once 'includes/config.php'; // Załącz plik konfiguracyjny bazy danych

if (isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if (isset($_POST['submit'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Proszę wypełnić wszystkie pola.';
    } else {
        $query = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $error = 'Nieprawidłowe dane logowania.';
            }
        } else {
            $error = 'Nieprawidłowe dane logowania.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie - Twój Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        /* Resetowanie domyślnych stylów */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Styl dla całego body */
body {
    font-family: 'Roboto', sans-serif;
    background-image: url("img/back-ground-log.webp");
    background-size: cover;
    color: #333; /* Kolor tekstu */
}

/* Styl dla głównego nagłówka */
header {
    text-align: center;
    padding: 20px 0;
}

header h1 {
    font-size: 36px;
    margin-bottom: 20px;
    color: #fff; /* Kolor tekstu */
}

/* Styl dla nawigacji */
/* Styl dla nawigacji */
nav {
    border-radius: 10px; /* Zaokrąglenie narożników nawigacji */
    background-color: rgba(0, 0, 0, 0.5); /* Przezroczyste tło */
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
    color: #fff; /* Kolor tekstu */
    font-size: 16px;
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
}

nav ul li a:hover,
nav ul li a:focus {
    background-color: #555; /* Kolor tła po najechaniu */
    color: #FFF; /* Kolor tekstu po najechaniu */
}


/* Styl dla sekcji logowania */
.wrapper {
    max-width: 380px;
    padding: 20px;
    margin: 0 auto;
    background-color: rgba(255, 255, 255, 0.8); /* Przezroczyste tło */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Cień */
}

.form-signin-heading {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid #ccc; /* Kolor obramowania */
    background-color: #f9f9f9; /* Kolor tła pola formularza */
    transition: border-color 0.3s ease-in-out, background-color 0.3s ease-in-out;
}

.form-control:focus {
    border-color: #333; /* Kolor obramowania po najechaniu */
    background-color: #fff; /* Kolor tła pola formularza po najechaniu */
}

.checkbox {
    margin-bottom: 20px;
}

.checkbox label {
    font-weight: normal;
}

.btn-primary {
    background-color: #007bff; /* Kolor tła przycisku */
    border-color: #007bff; /* Kolor obramowania przycisku */
    color: #fff; /* Kolor tekstu */
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out, color 0.3s ease-in-out;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: #0056b3; /* Kolor tła przycisku po najechaniu */
    border-color: #0056b3; /* Kolor obramowania przycisku po najechaniu */
    color: #fff; /* Kolor tekstu po najechaniu */
}

    </style>
</head>
<body>
<header>
    <h1>Login</h1>
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
<main>
    <div class="wrapper">
        <form class="form-signin" action="login.php" method="post">       
            <h2 class="form-signin-heading">Please login</h2>
            <?php if ($error != ''): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>
            <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password" required=""/>      
            <label class="checkbox">
                <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
            </label>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Login</button>   
        </form>
    </div>
</main>
<?php require_once 'includes/footer.php'; // Załącz stopkę ?>
</body>
</html>
