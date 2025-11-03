<?php
// --- 1. START SESSION & INCLUDE DATABASE ---
session_start();
include 'include/db_connect.php'; // Make sure this path is correct

$message = ''; // To store success or error messages

// --- 2. HANDLE FORM SUBMISSION (WHEN USER CLICKS "REGISTER") ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // --- IMPORTANT: Hash the password ---
    // We never store plain text passwords in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // --- IMPORTANT: Use Prepared Statements to prevent SQL Injection ---
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        
        // Bind parameters (s = string)
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // --- SUCCESS! ---
            $message = '<div class="message success">Registration successful! You can now <a href="login.php">login</a>.</div>';
        } else {
            // --- FAILURE (Check for duplicate email) ---
            if (mysqli_errno($conn) == 1062) { // 1062 is the error code for "Duplicate entry"
                $message = '<div class="message error">This email address is already registered.</div>';
            } else {
                $message = '<div class="message error">An error occurred. Please try again later.</div>';
            }
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
        
    } else {
         $message = '<div class="message error">Database preparation failed.</div>';
    }
    
    // Close the database connection
    mysqli_close($conn);
}

// --- 3. INCLUDE THE HEADER ---
// This line prints all the HTML from your header.php file
include 'include/header.php';
?>

<div class="form-container">
    <h2>Create an Account</h2>
    
    <?php echo $message; // Display any success or error messages here ?>
    
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
// --- 5. INCLUDE THE FOOTER ---
include 'include/footer.php';
?>