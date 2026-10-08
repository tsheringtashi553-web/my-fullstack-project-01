<?php

declare(strict_types=1);

// If this file is opened in a browser, show new lines properly.
if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('Content-Type: text/plain; charset=utf-8');
}

// Clean a Dzongkhag name: ' paro ' -> 'Paro'
function tidy_dzongkhag(string $name): string
{
    return ucfirst(strtolower(trim($name)));
}

// Clean a person's name: ' sonam ' -> 'Sonam'
function tidy_name(string $name): string
{
    return ucfirst(strtolower(trim($name)));
}

// A request is pending if it is Submitted or Under review.
function is_pending(string $status): bool
{
    return $status === 'Submitted' || $status === 'Under review';
}

// A valid CID is exactly 11 digits.
function is_valid_cid(string $cid): bool
{
    return strlen($cid) === 11 && ctype_digit($cid);
}

// Exercise 3: PAR-2026-0002
function make_reference(int $id, string $dzongkhag, string $submitted): string
{
    $part1 = strtoupper(substr(trim($dzongkhag), 0, 3)); // first 3 letters
    $part2 = substr($submitted, 0, 4);                   // the year
    // %04d pads the id with zeros to 4 digits.
    // If the id is 12345, sprintf does NOT cut it, so we get "12345".
    // That is acceptable: no data is lost, and the reference stays unique.
    $part3 = sprintf('%04d', $id);

    return $part1 . '-' . $part2 . '-' . $part3;
}

// Exercise 4: band for waiting days
function wait_band(int $days): string
{
    if ($days < 0) {
        return 'Check date';
    } elseif ($days <= 7) {
        return 'On time';
    } elseif ($days <= 14) {
        return 'Follow up';
    } else {
        return 'Overdue';
    }
}

// Exercise 5: the workflow rules stored in ONE array.
// Each status points to a list of statuses it may move to.
function status_rules(): array
{
    return [
        'Submitted'    => ['Under review'],
        'Under review' => ['Approved', 'Rejected'],
        'Rejected'     => ['Submitted'],
        'Approved'     => [],
    ];
}

function can_move(string $from, string $to): bool
{
    $rules = status_rules();
    // ?? [] means: if $from is unknown, use an empty list (no warning)
    $allowed = $rules[$from] ?? [];
    return in_array($to, $allowed, true);
}

// Extension: which role may move to which status
function can_move_as(string $role, string $from, string $to): bool
{
    $role_targets = [
        'officer'   => ['Under review'],
        'approver'  => ['Approved', 'Rejected'],
        'requester' => ['Submitted'],
    ];

    $allowed_targets = $role_targets[$role] ?? [];

    // The role must be allowed to move TO that status,
    // AND the workflow must allow the move.
    return in_array($to, $allowed_targets, true) && can_move($from, $to);
}
