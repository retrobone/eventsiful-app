<?php
include 'include/header.php';
include 'include/db_connect.php';

$event = null;
$event_id = 0;

if (isset($_GET['id'])) {
    $event_id = (int)$_GET['id'];
}

if ($event_id > 0) {
    $sql = "SELECT title, description, date, location, organizer FROM events WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $event_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 1) {
            $event = mysqli_fetch_assoc($result);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>

<div class="event-section">
    
    <?php if ($event):?>

        <div class="details-container">
            
            <h1><?php echo htmlspecialchars($event['title']); ?></h1>
            
            <div class="event-meta">
                <p><strong>Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($event['date'])); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <p><strong>Organized by:</strong> <?php echo htmlspecialchars($event['organizer']); ?></p>
            </div>
            
            <div class="event-description">
                <h2>About this Event</h2>
                <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            </div>

            <div class="registration-box">
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <a href="registration_form.php?event_id=<?php echo $event_id; ?>" class="btn-submit">
                        Register for this Event
                    </a>
                    
                <?php else: ?>
                    
                    <p>You must be logged in to register for this event.</p>
                    <a href="/login.php" class="btn-submit">Login to Register</a>
                    
                <?php endif; ?>
            </div>

        </div>

    <?php else:?>
        
        <div class="details-container">
            <h1>Event Not Found</h1>
            <p>Sorry, we couldn't find the event you're looking for.</p>
            <a href="index.php" class="btn-details">Back to all events</a>
        </div>

    <?php endif; ?>

</div>

<?php
include 'include/footer.php';

?>
