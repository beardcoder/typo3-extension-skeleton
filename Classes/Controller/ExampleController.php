<?php

declare(strict_types=1);

namespace Vendor\ExtensionSkeleton\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Example Controller for TYPO3 v13 Extbase
 *
 * This controller demonstrates the implementation of an Extbase controller
 * in TYPO3 v13 with modern PHP 8.2+ features and complete PHPDoc documentation.
 *
 * The controller provides example actions for typical CRUD operations and
 * shows best practices for:
 * - Dependency Injection
 * - Response Handling
 * - View Assignments
 * - Routing
 *
 * @package Vendor\ExtensionSkeleton\Controller
 * @author Your Name <your.email@example.com>
 * @license GPL-2.0-or-later
 */
class ExampleController extends ActionController
{
    /**
     * Constructor with Dependency Injection
     *
     * TYPO3 v13 uses Constructor Injection for all dependencies.
     * The PageRenderer is injected here as an example.
     *
     * @param PageRenderer $pageRenderer TYPO3 Page Renderer for asset handling
     */
    public function __construct(
        private readonly PageRenderer $pageRenderer
    ) {
    }

    /**
     * Index Action - List view
     *
     * This action displays a list of example data.
     * It demonstrates:
     * - View variable assignment
     * - Array data passing
     * - Response handling
     *
     * @return ResponseInterface The rendered response
     *
     * @throws \RuntimeException If the template is not found
     */
    public function indexAction(): ResponseInterface
    {
        // Add CSS/JS if needed
        $this->pageRenderer->addCssFile('EXT:extension_skeleton/Resources/Public/Css/styles.css');

        // Example data
        $items = $this->getExampleData();

        // Assign to view
        $this->view->assignMultiple([
            'items' => $items,
            'title' => 'Extension Skeleton - Index',
            'count' => count($items),
        ]);

        return $this->htmlResponse();
    }

    /**
     * Show Action - Detail view
     *
     * Displays details of a single item.
     * Demonstrates parameter passing via routing.
     *
     * @param int $id The ID of the item to display
     *
     * @return ResponseInterface The rendered response
     *
     * @throws \InvalidArgumentException If the ID is invalid
     * @throws \RuntimeException If the item is not found
     */
    public function showAction(int $id = 1): ResponseInterface
    {
        // Validate ID
        if ($id < 1) {
            throw new \InvalidArgumentException(
                sprintf('Invalid ID: %d. ID must be greater than 0.', $id),
                1702000001
            );
        }

        // Get item
        $item = $this->getItemById($id);

        if ($item === null) {
            throw new \RuntimeException(
                sprintf('Item with ID %d not found.', $id),
                1702000002
            );
        }

        // Assign to view
        $this->view->assignMultiple([
            'item' => $item,
            'title' => sprintf('Item #%d', $id),
        ]);

        return $this->htmlResponse();
    }

    /**
     * Returns example data
     *
     * In a real extension, this would fetch data from the database
     * or a repository.
     *
     * @return array<int, array{id: int, title: string, description: string, created: int}> Array with example items
     */
    private function getExampleData(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'First Example',
                'description' => 'This is the first example item',
                'created' => time() - 86400,
            ],
            [
                'id' => 2,
                'title' => 'Second Example',
                'description' => 'This is the second example item',
                'created' => time() - 43200,
            ],
            [
                'id' => 3,
                'title' => 'Third Example',
                'description' => 'This is the third example item',
                'created' => time(),
            ],
        ];
    }

    /**
     * Gets a single item by ID
     *
     * @param int $id The item ID
     *
     * @return array{id: int, title: string, description: string, created: int}|null The found item or null
     */
    private function getItemById(int $id): ?array
    {
        $items = $this->getExampleData();

        foreach ($items as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }

        return null;
    }
}
