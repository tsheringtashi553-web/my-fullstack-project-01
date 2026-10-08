<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

$today = '2026-10-07';

$overdue = 0;
$follow_up = 0;
$on_time = 0;

foreach ($requests as $r) {
    if (!is_pending($r['status'])) {
        continue; // skip Approved and Rejected
    }

    $days = intdiv(strtotime($today) - strtotime($r['submitted']), 86400);
    $band = wait_band($days);
    $name = tidy_name($r['first']) . ' ' . tidy_name($r['last']);

    echo "#{$r['id']} $name — $days days — $band\n";

    if ($band === 'Overdue') {
        $overdue++;
    } elseif ($band === 'Follow up') {
        $follow_up++;
    } elseif ($band === 'On time') {
        $on_time++;
    }
}

echo "$overdue overdue · $follow_up follow up · $on_time on time\n\n";

// Test the edges
foreach ([-1, 0, 7, 8, 14, 15] as $d) {
    echo "wait_band($d) = " . wait_band($d) . "\n";
}
// Expected: Check date, On time, On time, Follow up, Follow up, Overdue
