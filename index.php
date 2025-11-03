<?php
// 1. Include header
include 'include/header.php';
// 2. Include database connection
include 'include/db_connect.php';
?>

<div class="hero">
    <h1>Discover Your Next Event</h1>
    <p>Browse workshops, hackathons, and cultural fests.</p>
</div>

<div class="event-section">
    <h2>Upcoming Events</h2>
    <div class="event-grid">

        <?php
        // 3. Fetch upcoming events (NOW INCLUDES image_url)
        $sql_upcoming = "SELECT id, title, description, date, location, organizer, image_url 
                         FROM events 
                         WHERE date >= NOW() 
                         ORDER BY date ASC";
        
        $result_upcoming = null;
        if ($conn) {
            $result_upcoming = mysqli_query($conn, $sql_upcoming);
        }

        // 4. Loop and display upcoming events
        if ($result_upcoming && mysqli_num_rows($result_upcoming) > 0) :
            while ($event = mysqli_fetch_assoc($result_upcoming)) :
                
                // --- NEW IMAGE LOGIC ---
                // Use the scraped image if it exists, otherwise use the placeholder
                $image_source = $event['image_url'] 
                                ? htmlspecialchars($event['image_url']) 
                                : 'https://picsum.photos/400/200?random=' . $event['id'];
        ?>
        
                <div class="event-card">
                    <img src="<?php echo $image_source; ?>" 
                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                         class="event-card-image">

                    <div class="event-card-content">
                        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                        <p class="event-info">
                            <strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['date'])); ?>
                        </p>
                        <p class="event-info">
                            <strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?>
                        </p>
                        <p class="event-info">
                            <strong>By:</strong> <?php echo htmlspecialchars($event['organizer']); ?>
                        </p>
                        <a href="event_details.php?id=<?php echo $event['id']; ?>" class="btn-details">View Details</a>
                    </div> </div> <?php
            endwhile;
        else :
            echo "<p>No upcoming events found. Check back soon!</p>";
        endif;
        ?>

    </div> </div> <div class="event-section">
    <h2>Past Events</h2>
    <div class="event-grid">

        <?php
        // 5. Fetch past events (NOW INCLUDES image_url)
        $sql_past = "SELECT id, title, description, date, location, organizer, image_url 
                     FROM events 
                     WHERE date < NOW() 
                     ORDER BY date DESC";
        
        $result_past = null;
        if ($conn) {
            $result_past = mysqli_query($conn, $sql_past);
        }

        // 6. Loop and display past events
        if ($result_past && mysqli_num_rows($result_past) > 0) :
            while ($event = mysqli_fetch_assoc($result_past)) :
            
                // --- NEW IMAGE LOGIC ---
                $image_source = $event['image_url'] 
                                ? htmlspecialchars($event['image_url']) 
                                : 'https://picsum.photos/400/200?random=' . $event['id'];
        ?>
        
                <div class="event-card">
                    <img src="<?php echo $image_source; ?>" 
                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                         class="event-card-image">
                         
                    <div class="event-card-content">
                        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                        <p class="event-info">
                            <strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['date'])); ?>
                        </p>
                        <p class="event-info">
                            <strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?>
                        </p>
                        <p class="event-info">
                            <strong>By:</strong> <?php echo htmlspecialchars($event['organizer']); ?>
                        </p>
                        <a href="event_details.php?id=<?php echo $event['id']; ?>" class="btn-details">View Details</a>
                    </div> </div> <?php
            endwhile;
        else :
            echo "<p>No past events found.</p>";
        endif;
        ?>

    </div> </div> <?php
// 7. Close connection and include footer
if ($conn) {
    mysqli_close($conn);
}
include 'include/footer.php';
?>