<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventsiful</title> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
</head>
<body>

    <header class="header">
        <div class="header-left">
            <a href="/index.php">
                <p class="sitename">Eventsiful</p>
            </a>
        </div>

        <nav class="main-nav">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <span class="welcome-user">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                <a href="/my_registrations.php" class="buttonheader"><i class="fa-solid fa-calendar-check"></i> My Registrations</a>
                <a href="/logout.php" class="buttonheader"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            <?php else : ?>
                <a href="/login.php" class="buttonheader"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
                <a href="/register.php" class="buttonheader"><i class="fa-solid fa-user-plus"></i> Register</a>
            <?php endif; ?>
        </nav>
    </header>
    

    <main class="main">


