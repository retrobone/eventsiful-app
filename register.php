<?php
session_start();
include 'include/db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = '<div class="message success">Registration successful! You can now <a href="login.php">login</a>.</div>';
        } else {
            if (mysqli_errno($conn) == 1062) {
                $message = '<div class="message error">This email address is already registered.</div>';
            } else {
                $message = '<div class="message error">An error occurred. Please try again later.</div>';
            }
        }
        mysqli_stmt_close($stmt);
        
    } else {
         $message = '<div class="message error">Database preparation failed.</div>';
    }
    
    mysqli_close($conn);
}

include 'include/header.php';
?>

<div class="form-container">
    <h2>Create an Account</h2>
    
    <?php echo $message;?>
    
    <form action="register.php" method="POST">
        
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn-submit">Register</button>
        
        <p style="text-align: center; margin-top: 1rem;">
            Already have an account? <a href="/event-registration-system/login.php">Login here</a>
        </p>
    </form>
</div>

<?php
include 'include/footer.php';
?>