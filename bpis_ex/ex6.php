<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';

// FIXED version
function count_pending(array $requests): int
{
    $total = 0;

    for ($i = 0; $i < count($requests); $i++) {      // Bug 1 fixed: start at 0
        $status = $requests[$i]['status'];           // Bug 2 fixed: 'status' lowercase

        if ($status === 'Submitted' || $status === 'Under review') { // Bug 3 fixed: ===
            $total++;                                // Bug 4 fixed: actually add 1
        }
    }

    return $total;                                   // Bug 5 fixed: return the result
}

echo count_pending($requests) . "\n"; // 5
