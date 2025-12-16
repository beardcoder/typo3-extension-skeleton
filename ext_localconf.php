<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Vendor\ExtensionSkeleton\Controller\ExampleController;

defined('TYPO3') || die();

(function () {
    // Register Plugin
    ExtensionUtility::configurePlugin(
        'ExtensionSkeleton',
        'Example',
        [
            ExampleController::class => 'index, show',
        ],
        // Non-cacheable actions
        [
            ExampleController::class => '',
        ]
    );
})();
