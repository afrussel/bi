<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    $userCaptcha = trim($_POST['captcha']);
    $correctCaptcha = trim($_POST['captcha_answer']);

    // Validate captcha
    if ($userCaptcha !== $correctCaptcha) {
        echo "Incorrect captcha. Please try again.";
        exit;
    }

    // Recipient emails
    $to = "rasel365@yahoo.com, ceo@biturbollc.com";

    // Subject and body
    $email_subject = "New Contact Form Submission: $subject";
    $email_body = "You have received a new message from your website contact form:\n\n" .
                  "Name: $name\n" .
                  "Email: $email\n" .
                  "Phone: $phone\n" .
                  "Subject: $subject\n\n" .
                  "Message:\n$message";

    // Headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
