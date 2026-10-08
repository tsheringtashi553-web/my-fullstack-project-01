<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// ---- Part A: the 3 tests from the sheet (PASS / FAIL) ----
$tests = [
    // [id, dzongkhag, submitted, expected]
    [2, ' paro ',   '2026-09-20', 'PAR-2026-0002'],
    [6, 'Bumthang', '2026-10-03', 'BUM-2026-0006'],
    [1, 'Thimphu',  '2026-09-14', 'THI-2026-0001'],
];

echo "Tests\n";
foreach ($tests as $t) {
    $result = make_reference($t[0], $t[1], $t[2]);
    $status = ($result === $t[3]) ? 'PASS' : 'FAIL';
    echo "$status  $result (expected {$t[3]})\n";
}

// ---- Part B: a reference for all 8 records ----
echo "\nAll records\n";
foreach ($requests as $r) {
    // (int) and (string) make sure the types are right
    $ref = make_reference((int) $r['id'], (string) $r['dzongkhag'], (string) $r['submitted']);
    echo '#' . $r['id'] . '  ' . $ref . "\n";
}

// ---- Part C: what happens with id 12345? ----
echo "\nBig id\n";
echo make_reference(12345, 'Paro', '2026-09-20') . "\n"; // PAR-2026-12345
