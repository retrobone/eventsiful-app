<?php
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $user_message = strip_tags(trim($_POST["message"]));

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($user_message)) {
        $message = '<div class="message error">Please fill out all fields correctly.</div>';
    } else {
        $recipient = "your-email@example.com";
        $subject = "New Contact from $name";
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$user_message\n";
        $email_headers = "From: $name <$email>";

        if (mail($recipient, $subject, $email_content, $email_headers)) {
            $message = '<div class="message success">Thank you! Your message has been sent.</div>';
        } else {
            $message = '<div class="message error">Oops! Something went wrong.</div>';
        }
    }
}
?>

<?php include 'include/header.php'; ?>

<main class="main">
    <div class="form-container">
        <h2>Contact Us</h2>
        <p>Have a question? Fill out the form below to get in touch.</p>

        <?php echo $message; ?>

        <form action="contact.php" method="post">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Send Message</button>
        </form>
    </div>
</main>

<?php include 'include/footer.php'; ?>