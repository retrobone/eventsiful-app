<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>eventsiful - Event Registration System</title>
    <meta charset="UTF-8">
    <meta name="description" content="Find and register for college events, workshops, and hackathons.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <a href="index.php"><img class="home" src="https://cdn-icons-png.flaticon.com/512/61/61972.png" alt="Home Icon"></a>
            <h1 class="sitename">eventsiful</h1>
        </div>
        <div class="header-right">
            <a href="contact.php" class="buttonheader">Contact</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Show these links if the user is logged in -->
                <span class="welcome-user">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="logout.php" class="buttonheader">Logout</a>
            <?php else: ?>
                <!-- Show these links if the user is logged out -->
                <a href="register.php" class="buttonheader">Register</a>
                <a href="login.php" class="buttonheader">Login</a>
            <?php endif; ?>
        </div>
    </header>
</html>