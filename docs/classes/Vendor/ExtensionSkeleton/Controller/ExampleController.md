
Example Controller for TYPO3 v13 Extbase

This controller demonstrates the implementation of an Extbase controller
in TYPO3 v13 with modern PHP 8.2+ features and complete PHPDoc documentation.

The controller provides example actions for typical CRUD operations and
shows best practices for:
- Dependency Injection
- Response Handling
- View Assignments
- Routing

***

* Full name: `\Vendor\ExtensionSkeleton\Controller\ExampleController`
* Parent class: [`ActionController`](../../../TYPO3/CMS/Extbase/Mvc/Controller/ActionController)

## Properties

### pageRenderer

```php
private \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer
```

***

## Methods

### __construct

Constructor with Dependency Injection

```php
public __construct(\TYPO3\CMS\Core\Page\PageRenderer $pageRenderer): mixed
```

TYPO3 v13 uses Constructor Injection for all dependencies.
The PageRenderer is injected here as an example.

**Parameters:**

| Parameter       | Type                                  | Description                            |
|-----------------|---------------------------------------|----------------------------------------|
| `$pageRenderer` | **\TYPO3\CMS\Core\Page\PageRenderer** | TYPO3 Page Renderer for asset handling |

***

### indexAction

Index Action - List view

```php
public indexAction(): \Psr\Http\Message\ResponseInterface
```

This action displays a list of example data.
It demonstrates:
- View variable assignment
- Array data passing
- Response handling

**Return Value:**

The rendered response

**Throws:**

If the template is not found
- [`RuntimeException`](../../../RuntimeException)

***

### showAction

Show Action - Detail view

```php
public showAction(int $id = 1): \Psr\Http\Message\ResponseInterface
```

Displays details of a single item.
Demonstrates parameter passing via routing.

**Parameters:**

| Parameter | Type    | Description                   |
|-----------|---------|-------------------------------|
| `$id`     | **int** | The ID of the item to display |

**Return Value:**

The rendered response

**Throws:**

If the ID is invalid
- [`InvalidArgumentException`](../../../InvalidArgumentException)
If the item is not found
- [`RuntimeException`](../../../RuntimeException)

***

### getExampleData

Returns example data

```php
private getExampleData(): array<int,array{id: int, title: string, description: string, created: int}>
```

In a real extension, this would fetch data from the database
or a repository.

**Return Value:**

Array with example items

***

### getItemById

Gets a single item by ID

```php
private getItemById(int $id): array{id: int, title: string, description: string, created: int}|null
```

**Parameters:**

| Parameter | Type    | Description |
|-----------|---------|-------------|
| `$id`     | **int** | The item ID |

**Return Value:**

The found item or null

***
