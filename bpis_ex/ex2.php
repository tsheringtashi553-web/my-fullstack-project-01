<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

//count pending requests for each Dzongkhag
$counts = [];
foreach ($requests as $r) {
    if (is_pending($r['status'])) {
        $name = tidy_dzongkhag($r['dzongkhag']); // ' paro ' -> 'Paro'
        if (!isset($counts[$name])) {
            $counts[$name] = 0;
        }
        $counts[$name]++;
    }
}

//find the highest count
$highest = 0;
foreach ($counts as $name => $count) {
    if ($count > $highest) {
        $highest = $count;
    }
}

//print every Dzongkhag with the highest count (handles ties)
foreach ($counts as $name => $count) {
    if ($count === $highest) {
        echo "Busiest: $name ($count pending)\n";
    }
}
