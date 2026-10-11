<?php
declare(strict_types=1);

function formatSalaryRange(float $from, float $to, string $currency = '$'): string {
    $formattedFrom = number_format($from, 0, '.', ' ');
    $formattedTo = number_format($to, 0, '.', ' ');
    
    if ($from === $to) {
        return "{$currency}{$formattedFrom}";
    }
    
    return "{$currency}{$formattedFrom} – {$currency}{$formattedTo}";
}

function isExpired(string $expirationDate): bool {
    $expTimestamp = strtotime($expirationDate);
    if ($expTimestamp === false) {
        return false;
    }
    return $expTimestamp < strtotime('today');
}

function renderStatusBadge(string $expirationDate): string {
    if (isExpired($expirationDate)) {
        return '<span class="badge badge-expired">Архівна (до ' . htmlspecialchars($expirationDate) . ')</span>';
    }
    return '<span class="badge badge-active">Активна (до ' . htmlspecialchars($expirationDate) . ')</span>';
}