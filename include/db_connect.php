<?php
// Database credentials
define('DB_HOST', 'mysql-db'); // Your database host (usually 'localhost')
define('DB_USER', 'hi10berg'); // Your database username
define('DB_PASS', 'smple1'); // Your database password
define('DB_NAME', 'events');     // Your database name

// Create a database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if the connection was successful
if (!$conn) {
    // If connection fails, stop the script and display an error
    die("Connection failed: " . mysqli_connect_error());
}

// Set the character set to utf8 (good practice)
mysqli_set_charset($conn, "utf8");

?>




