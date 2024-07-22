<?php
require_once 'includes/config.php'; // Załącz plik konfiguracyjny bazy danych
session_start();

// Pobieranie najnowszych postów z bazy danych
$query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts JOIN users ON posts.author_id = users.id ORDER BY created_at DESC LIMIT 100";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Blog ZegarkiDawida</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
/* Resetowanie stylów */
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed,
figure, figcaption, footer, header, hgroup,
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}

/* Globalne style */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f9f9f9;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

header h1 {
    font-size: 36px;
    margin: 0; /* Zmiana: Dodanie zerowania marginesu */
}

nav ul {
    list-style: none;
}

nav ul li {
    display: inline-block;
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

main {
    padding: 20px;
}

.posts {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Zmiana: po dwa posty w wierszu */
    gap: 20px;
}

.post {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    width: 100%;
}

.post h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.post p {
    margin-bottom: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

.buy-my-blog {
    background-color: #eee;
    padding: 40px 0;
    text-align: center;
}

.buy-my-blog img {
    margin-bottom: 20px;
}

.buy-my-blog p {
    font-size: 18px;
}

.buy-my-blog button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    cursor: pointer;
    margin-top: 20px;
}

.buy-my-blog button:hover {
    background-color: #555;
}


    </style>
</head>
<body>
<header>
    <h1>Witaj na Blogu! ZegarkiDawida</h1>
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
    <?php if ($result && $result->num_rows > 0): ?>
        <section class="posts">
            <?php while($row = $result->fetch_assoc()): ?>
                <article class="post">
                    <h2><a href="post.php?id=<?= $row['id']; ?>"><?= htmlspecialchars($row['title']); ?></a></h2>
                    <p><?= substr(htmlspecialchars($row['content']), 0, 200); ?>...</p>
                    <footer>
                        <span>Autor: <?= htmlspecialchars($row['username']); ?></span>
                        <span>Data: <?= $row['created_at']; ?></span>
                    </footer>
                </article>
            <?php endwhile; ?>
        </section>
    <?php else: ?>
        <p>Brak postów do wyświetlenia.</p>
    <?php endif; ?>
</main>

<section class="buy-my-blog">
    <div class="container">
        <img src="img/blog.jpg" alt="Kup mój blog" style="max-width: 100%; height: auto;">
        <p>Interesuje Cię zakup tego bloga? <a href="contact.php">Skontaktuj się ze mną!</a></p>
        <!-- Dodanie przycisku "Kup teraz" -->
        <button onclick="location.href='https://1ct.eu/EyRXl'" style="padding: 10px 20px; background-color: #333; color: #fff; border: none; cursor: pointer; margin-top: 20px;">Kup teraz</button>
    </div>
</section>

<footer>
    <p>&copy; 2024 ZegarkiDawida. Wszelkie prawa zastrzeżone.</p>
</footer>

</body>
</html>
