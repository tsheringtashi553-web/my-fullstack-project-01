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

/*
BUG LOG
#  Symptom                                   Cause                                   Fix
1  First record was skipped (wrong count)    Loop started at $i = 1, arrays start 0  $i = 0
2  Warning: Undefined array key "Status"     Key is 'status' (lower-case)            'status'
3  Every record counted as pending           '=' assigns, '===' compares             use ===
4  Total stayed 0                            '$total + 1' calculates but never saves $total++
5  Error: no return value (TypeError)        Function promised int but returned none return $total;
*/
