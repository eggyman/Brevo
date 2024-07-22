
<?php

// Load CSV data
$data = array_map('str_getcsv', file('brevo_casestudy_data.csv'));
array_shift($data); // Remove header

// Define weights
$w1 = 2.0; // Weight for open rate
$w2 = -3.0; // Weight for unsubscription rate
$w3 = -2.0; // Weight for bounce rate
$w4 = -4.0; // Weight for complaint rate

// Calculate scores
$scores = [];
foreach ($data as $row) {
    $id = $row[0];
    $emails_sent = $row[1];
    $open_rate = $row[2];
    $unsubscribe_rate = $row[3];
    $bounce_rate = $row[4];
    $complaint_rate = $row[5];
    
    $score = ($w1 * $open_rate) - ($w2 * $unsubscribe_rate) - ($w3 * $bounce_rate) - ($w4 * $complaint_rate);
    $scores[] = [
        'id' => $id,
        'score' => $score,
        'emails_sent' => $emails_sent,
        'open_rate' => $open_rate,
        'unsubscribe_rate' => $unsubscribe_rate,
        'bounce_rate' => $bounce_rate,
        'complaint_rate' => $complaint_rate
    ];
}

// Open the file in write mode
$fp = fopen('scores.csv', 'w');
if ($fp === false) {
    die('Error opening the file scores.csv');
}

// Write the header row
fputcsv($fp, ['ID', 'Score', 'Emails Sent', 'Open Rate', 'Unsubscription Rate', 'Bounce Rate', 'Complaint Rate']);

// Write the scores to the file
foreach ($scores as $row) {
    fputcsv($fp, $row);
}

// Close the file
fclose($fp);

echo "Scores calculated and saved to scores.csv\n";
?>