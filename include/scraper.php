<?php
include 'db_connect.php';

echo "<h1>Event Scraper (v4 - Scrapes Images)</h1>";
echo "<p>Attempting to scrape titles, dates, and images...</p>";

$url = "https://professional.mit.edu/events";
$base_url = "https://professional.mit.edu";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$html_content = curl_exec($ch);

if (curl_errno($ch)) {
    die("cURL Error: " . curl_error($ch));
}
curl_close($ch);

if ($html_content === FALSE || empty($html_content)) {
    die("Error: Failed to fetch content.");
}

$dom = new DOMDocument();
@$dom->loadHTML($html_content);
$xpath = new DOMXPath($dom);

$event_nodes = $xpath->query('//article[contains(@class, "node--type-events")]');

if ($event_nodes->length == 0) {
    die("No event nodes found. The website structure might have changed.");
}

echo "<p>Found " . $event_nodes->length . " events. Processing...</p>";

$sql = "INSERT INTO events (title, description, date, location, organizer, image_url) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Database prepare failed: " . mysqli_error($conn));
}

$title = "";
$description = "Scraped Event";
$mysql_date = "";
$location = "Online";
$organizer = "MIT";
$image_url = "";

mysqli_stmt_bind_param($stmt, "ssssss", $title, $description, $mysql_date, $location, $organizer, $image_url);

$added_count = 0;

foreach ($event_nodes as $node) {
    
    $title_node = $xpath->query('.//div[@class="faux-full-title"]', $node)->item(0);
    
    $date_node = $xpath->query('.//span[contains(@class, "date-display-range")] | .//div[contains(@class, "field--name-field-event-dates")]', $node)->item(0);
    
    $image_node = $xpath->query('.//img', $node)->item(0);

    if (!$title_node || !$date_node || !$image_node) {
        echo "<b>SKIPPED:</b> An event was missing a title, date, or image.<br>";
        continue;
    }

    $title = trim($title_node->nodeValue);
    
    $image_src = $image_node->getAttribute('src');
    $image_url = $base_url . $image_src;

    $raw_date_text = trim($date_node->nodeValue);
    $date_parts = explode('-', $raw_date_text);
    $start_date_part = trim($date_parts[0]);
    if (strpos($start_date_part, ',') === false) {
        $end_date_part = trim($date_parts[count($date_parts) - 1]);
        $year_pos = strrpos($end_date_part, ',');
        $year = trim(substr($end_date_part, $year_pos + 1));
        $clean_date_text = $start_date_part . ", " . $year;
    } else {
        $clean_date_text = $start_date_part;
    }
    $timestamp = strtotime($clean_date_text);
    $mysql_date = ($timestamp === false) ? "2025-01-01 00:00:00" : date('Y-m-d H:i:s', $timestamp);
    
    $check_sql = "SELECT id FROM events WHERE title = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $title);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($result) == 0) {
        if (mysqli_stmt_execute($stmt)) {
            echo "<b>SUCCESS:</b> Added '<i>" . htmlspecialchars($title) . "</i>' with image.<br>";
            $added_count++;
        }
    } else {
         echo "<b>SKIPPED:</b> Event already exists: " . htmlspecialchars($title) . "<br>";
    }
    mysqli_stmt_close($check_stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo "<h3>Scraping complete! Added $added_count new events.</h3>";
echo '<a href="/index.php">Go back to homepage to see them!</a>'; 


?>
