<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Step 1: group request ids by CID
$groups = [];
foreach ($requests as $r) {
    $cid = $r['cid'];
    if (!isset($groups[$cid])) {
        $groups[$cid] = []; // start an empty list for this CID
    }
    $groups[$cid][] = $r['id']; // add the id to the list
}

// Step 2: print only CIDs used by more than one request
foreach ($groups as $cid => $ids) {
    if (count($ids) > 1) {
        echo "Duplicate $cid: requests " . implode(', ', $ids) . "\n";
    }
}

// Step 3: list invalid CIDs
foreach ($requests as $r) {
    if (!is_valid_cid($r['cid'])) {
        echo "Invalid CID in request {$r['id']}: {$r['cid']}\n";
    }
}

// Think about: a duplicate is not always an error. Requests 1 and 4 may be
// two changes for the same person (e.g. a past rejection and a new try).
// But different names on the same CID could be a typo or fraud, so Karma
// should check the records and contact the requester before deciding.
