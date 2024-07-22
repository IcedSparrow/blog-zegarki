<?php
require_once 'includes/config.php'; // Include the database connection

// Ensure an ID is present and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $postId = $_GET['id'];

    // Fetch the post from the database
    $query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts JOIN users ON posts.author_id = users.id WHERE posts.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        header("Location: index.php"); // Redirect to index if no post found
        exit;
    }
} else {
    header("Location: index.php"); // Redirect to index if ID is not set or not valid
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Adjust path as needed -->
    <style>
/* Resetowanie podstawowych stylów */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Styl dla całej strony */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    background-image: url('img/blog.webp'); /* Dodanie tła zdjęcia */
    background-size: cover; /* Dopasowanie tła do całej powierzchni */
    background-position: center; /* Pozycjonowanie tła na środku */
}

/* Styl dla nagłówka */
header {
    background-color: #333;
    color: #fff;
    padding: 20px;
}

header h1 a {
    color: #fff;
    text-decoration: none;
    font-size: 24px;
}

/* Styl dla animacji powrotu do bloga */
header h1 a:hover {
    animation: heartbeat 1s infinite;
}

@keyframes heartbeat {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

/* Styl dla treści głównej */
main {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
}

.post-detail {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    width: 100%;
}

.post-detail h2 {
    color: #333;
    margin-bottom: 10px;
}

.post-detail img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
}

.post-detail p {
    color: #555;
    line-height: 1.6;
}

.post-detail footer {
    margin-top: 20px;
    color: #777;
}

/* Styl dla stopki */
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}
/* Styl dla nagłówka */
header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    transition: background-color 0.3s ease; /* Dodanie animacji */
}

header:hover {
    background-color: #555; /* Zmiana koloru po najechaniu */
}

header h1 a {
    color: #fff;
    text-decoration: none;
    font-size: 24px;
    transition: color 0.3s ease; /* Dodanie animacji */
}

header h1 a:hover {
    color: #ffcc00; /* Zmiana koloru po najechaniu */
}

</style>

</head>
<body>
    <header>
        <h1><a href="index.php">Powrót do bloga</a></h1>
    </header>

    <main>
        <article class="post-detail">
            <h2><?= htmlspecialchars($post['title']); ?></h2>
            <?php if (!empty($post['image_path'])): ?>
                <img src="<?= htmlspecialchars($post['image_path']); ?>" alt="Obrazek dołączony do posta">
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($post['content'])); ?></p>
            <footer>
                <span>Autor: <?= htmlspecialchars($post['username']); ?></span>
                <span>Data: <?= $post['created_at']; ?></span>
            </footer>
        </article>
    </main>

    <footer class="text-center">
        <p>&copy; 2024 ZegarkiDawida. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
