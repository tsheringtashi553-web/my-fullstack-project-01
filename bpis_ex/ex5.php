<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Test moves: [from, to, expected]
$tests = [
    ['Submitted',    'Under review', true],
    ['Submitted',    'Approved',     false],
    ['Under review', 'Rejected',     true],
    ['Approved',     'Submitted',    false],
    ['Rejected',     'Submitted',    true],
    ['Closed',       'Submitted',    false],
];

foreach ($tests as $t) {
    $result = can_move($t[0], $t[1]) ? 'Allowed' : 'Blocked';
    echo "{$t[0]} → {$t[1]}: $result\n";
}

echo "\n";

// Extension: roles
var_dump(can_move_as('officer', 'Under review', 'Approved'));   // false
var_dump(can_move_as('approver', 'Under review', 'Approved'));  // true
var_dump(can_move_as('requester', 'Rejected', 'Submitted'));    // true
