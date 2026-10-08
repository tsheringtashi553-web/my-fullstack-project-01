<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Snippet A
// Prediction: none | 0
// Reason: ?: treats 0 as "empty", so it gives 'none'.
//         ?? only replaces null, and 0 is not null, so it keeps 0.
$x = 0;
$label = $x ?: 'none';
$size = $x ?? 'none';
echo "snippet A: ";
echo "$label | $size\n";

// Snippet B
// Prediction: 19
// Reason: adds 1, 2, 4, 5, 7 (skips 3 and 6 with continue).
//         At 8 the break stops the loop. 1+2+4+5+7 = 19.
$total = 0;
for ($i = 1; $i <= 10; $i++) {
    if ($i % 3 === 0) {
        continue;
    }
    if ($i > 7) {
        break;
    }
    $total += $i;
}
echo "snippet B: ";
echo $total . "\n";

// Snippet C
// Prediction: BaC
// Reason: only values bigger than 1 (b=2, c=3) are made uppercase.
$m = ['b' => 2, 'a' => 1, 'c' => 3];
$out = '';
foreach ($m as $k => $v) {
    $up = $v > 1;
    $out .= $up ? strtoupper($k) : $k;
}
echo "snippet C: ";
echo $out . "\n";

// Snippet D
// Prediction: 4ro
// Reason: trim removes the spaces, so 'Paro' has length 4.
//         substr('Paro', -2) takes the last 2 letters: 'ro'.
$n = strlen(trim(' Paro '));
echo "snippet D: ";
echo $n . substr('Paro', -2) . "\n";
