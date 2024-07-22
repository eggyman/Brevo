<?php
$scores = array_map('str_getcsv', file('scores.csv'));
array_shift($scores); // Remove header

// Sort by emails sent
usort($scores, function($a, $b) {
    return $b[2] - $a[2];
});

// Calculate total emails sent
$total_emails_sent = array_sum(array_column($scores, 2));
$group_size = $total_emails_sent / 3;

// Categorize into three groups
$group1 = $group2 = $group3 = [];
$current_sum = 0;
foreach ($scores as $row) {
    if ($current_sum + $row[2] <= $group_size) {
        $group1[] = $row;
    } elseif ($current_sum + $row[2] <= 2 * $group_size) {
        $group2[] = $row;
    } else {
        $group3[] = $row;
    }
    $current_sum += $row[2];
}

// Save categorized data
function save_group($group, $filename) {
    $fp = fopen($filename, 'w');
    if ($fp === false) {
        die("Error opening the file $filename");
    }
    // Write header
    fputcsv($fp, ['ID', 'Score', 'Emails Sent', 'Open Rate', 'Unsubscription Rate', 'Bounce Rate', 'Complaint Rate']);
    foreach ($group as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
}

save_group($group1, 'group1.csv');
save_group($group2, 'group2.csv');
save_group($group3, 'group3.csv');

echo "Clients categorized into three groups and saved to group1.csv, group2.csv, and group3.csv\n";
?>