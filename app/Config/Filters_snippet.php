<?php
/**
 * Add these lines to your project's existing app/Config/Filters.php
 */

// 1. Register the alias (inside the $aliases array):
public array $aliases = [
    // ...existing aliases...
    'apikey' => \App\Filters\ApiKeyFilter::class,
];

// 2. (Optional) If you'd rather apply it globally to all /api/* routes
//    instead of per-route-group in Routes.php:
public array $filters = [
    'apikey' => ['before' => ['api/*']],
];
