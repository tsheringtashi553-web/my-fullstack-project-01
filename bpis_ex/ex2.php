<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Step 1: count pending requests for each Dzongkhag
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

// Step 2: find the highest count
$highest = 0;
foreach ($counts as $name => $count) {
    if ($count > $highest) {
        $highest = $count;
    }
}

// Step 3: print every Dzongkhag with the highest count (handles ties)
foreach ($counts as $name => $count) {
    if ($count === $highest) {
        echo "Busiest: $name ($count pending)\n";
    }
}

// Think about: if I forget to tidy the names, 'paro' and 'Paro' are counted
// as two different places. Each gets 1 pending, so the answer is wrong
// (a tie of 1 between several places instead of Paro with 2).
