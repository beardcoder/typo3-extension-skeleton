<?php

declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extension Skeleton',
    'description' => 'TYPO3 v13 Extension Skeleton with Auto-Documentation',
    'category' => 'plugin',
    'author' => 'Your Name',
    'author_email' => 'your.email@example.com',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.99.99',
            'php' => '8.2.0-8.3.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Vendor\\ExtensionSkeleton\\' => 'Classes/',
        ],
    ],
];
