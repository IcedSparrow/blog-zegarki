<?php
// Adres e-mail, na który będą wysyłane wiadomości
$to = 'dawidwrobel40@gmail.com';

// Temat wiadomości e-mail
$subject = 'Wiadomość z formularza kontaktowego';

// Pobranie danych z formularza
$name = strip_tags($_POST['name']);
$email = strip_tags($_POST['email']);
$message = strip_tags($_POST['message']);

// Utworzenie wiadomości
$body = "Otrzymałeś nową wiadomość z formularza kontaktowego.\n\n"."Oto szczegóły:\n\nImię: $name\n\nEmail: $email\n\nWiadomość:\n$message";

// Dodatkowe nagłówki
$headers = "From: $email\n";
$headers .= "Reply-To: $email";

// Wysłanie wiadomości
if(mail($to, $subject, $body, $headers)){
    echo 'Wiadomość została wysłana pomyślnie.';
} else{
    echo 'Nie udało się wysłać wiadomości.';
}
?>
