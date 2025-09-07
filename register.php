<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $message = '<div class="message success">Thank you for registering, ' . htmlspecialchars($name) . '! (This is a demo - no data was saved).</div>';
}
?>

<?php include 'include/header.php'; ?>

<main class="main">
    <div class="form-container">
        <h2>Create an Account</h2>
        <p>Join eventsiful to discover and register for events.</p>

        <?php echo $message; ?>

        <form action="register.php" method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
                <span class="error-message" id="name-error"></span>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message" id="email-error"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="error-message" id="password-error"></span>
            </div>
            <button type="submit" class="btn-submit">Register</button>
        </form>
         <p style="text-align: center; margin-top: 20px;">
            Already have an account? <a href="login.php" style="color: #4A90E2;">Login here</a>
        </p>
    </div>
</main>

<?php include 'include/footer.php'; ?>

