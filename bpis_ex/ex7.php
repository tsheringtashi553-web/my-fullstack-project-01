<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

//group request ids by CID
$groups = [];
foreach ($requests as $r) {
    $cid = $r['cid'];
    if (!isset($groups[$cid])) {
        $groups[$cid] = []; // start an empty list for this CID
    }
    $groups[$cid][] = $r['id']; // add the id to the list
}

//print only CIDs used by more than one request
foreach ($groups as $cid => $ids) {
    if (count($ids) > 1) {
        echo "Duplicate $cid: requests " . implode(', ', $ids) . "\n";
    }
}

//list invalid CIDs
foreach ($requests as $r) {
    if (!is_valid_cid($r['cid'])) {
        echo "Invalid CID in request {$r['id']}: {$r['cid']}\n";
    }
}
