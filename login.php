<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strip_tags(trim($_POST["email"]));
    $message = '<div class="message success">Login attempt for ' . htmlspecialchars($email) . ' successful! (This is a demo).</div>';
}
?>

<?php include 'include/header.php'; ?>

<main class="main">
    <div class="form-container">
        <h2>Login to Your Account</h2>
        <p>Welcome back! Please enter your details.</p>
        
        <?php echo $message; ?>

        <form action="login.php" method="post">
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
            <button type="submit" class="btn-submit">Login</button>
        </form>
        <p style="text-align: center; margin-top: 20px;">
            Don't have an account? <a href="register.php" style="color: #4A90E2;">Register here</a>
        </p>
    </div>
</main>

<?php include 'include/footer.php'; ?>

