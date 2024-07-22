<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kontakt - Twój Blog</title>
    <style>
        /* Resetowanie domyślnych stylów */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Obraz tła */
        body {
            background-image: url("img/contact.webp");
            background-size: cover;
            background-position: center;
        }
        
        /* Styl nagłówka */
        header {
            background: linear-gradient(to right, #333, #666);
            color: #fff;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Styl nawigacji */
        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffc107;
        }

        /* Styl formularza kontaktowego */
        .contact-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: linear-gradient(to bottom, #f9f9f9, #e9e9e9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .contact-form h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .contact-form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .contact-form textarea {
            resize: vertical;
        }

        .contact-form button[type="submit"] {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }

        .contact-form button[type="submit"]:hover {
            background: linear-gradient(to right, #0056b3, #003a75);
        }

        /* Styl stopki */
        footer {
            background-color: rgba(51, 51, 51, 0.5); /* Kolor z przezroczystością */
            color: #fff;
            text-align: center;
            padding: 20px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            margin-top: 20px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Kontakt</h1>
        <nav>
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="about.php">O mnie</a></li>
                <li><a href="contact.php">Kontakt</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="contact-form">
            <h2>Masz pytania? Napisz do mnie!</h2>
            <form action="send-message.php" method="POST">
                <label for="name">Imię:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Wiadomość:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit" name="submit">Wyślij</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ZegarkiDawida. Wszelkie prawa zastrzeżone.</p>
    </footer>

</body>
</html>
