<?php

declare(strict_types=1);

use Vendor\ExtensionSkeleton\Middleware\ExampleMiddleware;

return [
    'frontend' => [
        'vendor/extension-skeleton/example-middleware' => [
            'target' => ExampleMiddleware::class,
            'before' => [
                'typo3/cms-frontend/page-resolver',
            ],
            'after' => [
                'typo3/cms-frontend/tsfe',
            ],
        ],
    ],
];
