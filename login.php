<?php
// --- 1. START SESSION & INCLUDE DATABASE ---
session_start(); 
include 'include/db_connect.php'; // Make sure this path is correct

$message = ''; // To store success or error messages

// --- 2. HANDLE FORM SUBMISSION (WHEN USER CLICKS "LOGIN") ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id, name, password, role FROM users WHERE email = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify the hashed password
            if (password_verify($password, $user['password'])) {
                // --- SUCCESS! ---
                // Store user data in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirect to the homepage
                header("Location: index.php"); 
                exit();
            } else {
                // --- WRONG PASSWORD ---
                $message = '<div class="message error">Invalid password. Please try again.</div>';
            }
        } else {
            // --- NO USER FOUND ---
            $message = '<div class="message error">No user found with that email.</div>';
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = '<div class="message error">Database query failed.</div>';
    }
    mysqli_close($conn);
}

include 'include/header.php'; 
?>

<div class="form-container">
    <h2>Login to Your Account</h2>
    
    <?php echo $message; // Display any error messages here ?>
    
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn-submit">Login</button>
        
        <p style="text-align: center; margin-top: 1rem;">
            Don't have an account? <a href="/event-registration-system/register.php">Register here</a>
        </p>
    </form>
</div>

<?php include 'include/footer.php'; ?>