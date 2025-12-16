# Getting Started

Dieses Skeleton bietet eine vollständige TYPO3 v13 Extension-Struktur mit integrierter Dokumentations-Pipeline.

## Voraussetzungen

- PHP 8.2 oder höher
- TYPO3 v13.x
- Composer
- Node.js 18+ und npm (für die Dokumentation)

## Installation

### 1. Repository klonen

```bash
git clone https://github.com/yourusername/typo3-extension-skeleton.git my-extension
cd my-extension
```

### 2. Namespace anpassen

Ersetze in allen Dateien:
- `Vendor\ExtensionSkeleton` → `YourVendor\YourExtension`
- `extension_skeleton` → `your_extension_key`

Betroffene Dateien:
- `composer.json`
- `ext_emconf.php`
- `ext_localconf.php`
- `Configuration/Services.yaml`
- `Configuration/RequestMiddlewares.php`
- Alle PHP-Dateien in `Classes/`

### 3. Dependencies installieren

```bash
# PHP Dependencies
composer install

# Node Dependencies (für Dokumentation)
npm install
```

## Extension-Struktur

```
.
├── Classes/
│   ├── Controller/
│   │   └── ExampleController.php      # Extbase Controller
│   └── Middleware/
│       └── ExampleMiddleware.php      # PSR-15 Middleware
├── Configuration/
│   ├── RequestMiddlewares.php         # Middleware-Registrierung
│   ├── Routes/
│   │   └── Default.yaml               # Routing-Config
│   └── Services.yaml                  # DI Container
├── Resources/
│   ├── Private/
│   │   ├── Templates/                 # Fluid Templates
│   │   ├── Layouts/                   # Fluid Layouts
│   │   └── Partials/                  # Fluid Partials
│   └── Public/
│       └── Css/                       # Styles
├── Build/
│   └── PhpDocGenerator.php            # Dokumentations-Generator
├── docs/
│   ├── .vitepress/
│   │   └── config.ts                  # VitePress Config
│   └── generated/                     # Generierte Docs (auto)
├── composer.json
├── ext_emconf.php
├── ext_localconf.php
├── package.json
└── Makefile
```

## Erste Schritte

### 1. Dokumentation generieren

```bash
# Via Composer
composer docs:generate

# Via Makefile
make docs
```

Dies parst alle PHP-Dateien und generiert Markdown-Dokumentation aus den PHPDoc-Blöcken.

### 2. Dokumentation anschauen

```bash
# Dev-Server starten
npm run docs:dev

# oder via Makefile
make docs-serve
```

Öffne http://localhost:5173 im Browser.

### 3. Eigene Funktionalität hinzufügen

Erweitere die Extension um deine eigene Logik:

```php
<?php
declare(strict_types=1);

namespace YourVendor\YourExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * My Custom Controller
 *
 * Beschreibung deines Controllers
 *
 * @package YourVendor\YourExtension\Controller
 */
class MyController extends ActionController
{
    /**
     * List Action
     *
     * Zeigt eine Liste von Items
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        // Deine Logik hier

        return $this->htmlResponse();
    }
}
```

### 4. Dokumentation neu generieren

Nach jeder Änderung an den PHPDoc-Kommentaren:

```bash
composer docs:generate
```

Die Dokumentation wird automatisch aktualisiert.

## Wichtige Konzepte

### PHPDoc für Auto-Documentation

Verwende vollständige PHPDoc-Blöcke:

```php
/**
 * Kurzbeschreibung der Methode
 *
 * Längere Beschreibung mit mehr Details über
 * die Funktionsweise der Methode.
 *
 * @param string $param1 Beschreibung Parameter 1
 * @param int $param2 Beschreibung Parameter 2
 *
 * @return array Das Ergebnis
 *
 * @throws \InvalidArgumentException Wenn Parameter ungültig
 */
public function myMethod(string $param1, int $param2): array
{
    // ...
}
```

### Middleware in TYPO3 v13

Middleware werden in `Configuration/RequestMiddlewares.php` registriert:

```php
return [
    'frontend' => [
        'your-vendor/your-middleware' => [
            'target' => YourMiddleware::class,
            'before' => ['typo3/cms-frontend/page-resolver'],
            'after' => ['typo3/cms-frontend/tsfe'],
        ],
    ],
];
```

### Dependency Injection

Verwende Constructor Injection in TYPO3 v13:

```php
public function __construct(
    private readonly MyService $myService,
    private readonly PageRenderer $pageRenderer
) {
}
```

## Nächste Schritte

- [API-Dokumentation ansehen](/generated/index)
- [Installation in TYPO3](/installation)
- Eigene Controller und Middleware hinzufügen
- Dokumentation generieren und deployen
