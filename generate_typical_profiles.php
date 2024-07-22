<?php
function calculate_typical_profile($group) {
    $count = count($group);
    $totals = array_reduce($group, function($carry, $item) {
        // Ensure the row has all required columns
        if (count($item) < 7) {
            return $carry;
        }
        $carry['score'] += $item[1];
        $carry['emails_sent'] += $item[2];
        $carry['open_rate'] += $item[3];
        $carry['unsubscribe_rate'] += $item[4];
        $carry['bounce_rate'] += $item[5];
        $carry['complaint_rate'] += $item[6];
        return $carry;
    }, ['score' => 0, 'emails_sent' => 0, 'open_rate' => 0, 'unsubscribe_rate' => 0, 'bounce_rate' => 0, 'complaint_rate' => 0]);
    
    return [
        'average_score' => $count > 0 ? $totals['score'] / $count : 0,
        'average_emails_sent' => $count > 0 ? $totals['emails_sent'] / $count : 0,
        'average_open_rate' => $count > 0 ? $totals['open_rate'] / $count : 0,
        'average_unsubscribe_rate' => $count > 0 ? $totals['unsubscribe_rate'] / $count : 0,
        'average_bounce_rate' => $count > 0 ? $totals['bounce_rate'] / $count : 0,
        'average_complaint_rate' => $count > 0 ? $totals['complaint_rate'] / $count : 0
    ];
}

function load_group($filename) {
    $group = array_map('str_getcsv', file($filename));
    array_shift($group); // Remove header
    return $group;
}

$group1 = load_group('group1.csv');
$group2 = load_group('group2.csv');
$group3 = load_group('group3.csv');

$typical_profile_group1 = calculate_typical_profile($group1);
$typical_profile_group2 = calculate_typical_profile($group2);
$typical_profile_group3 = calculate_typical_profile($group3);

$typical_profiles = [
    'group1' => $typical_profile_group1,
    'group2' => $typical_profile_group2,
    'group3' => $typical_profile_group3
];

file_put_contents('typical_profiles.json', json_encode($typical_profiles));

echo "Typical profiles calculated and saved to typical_profiles.json\n";
?>