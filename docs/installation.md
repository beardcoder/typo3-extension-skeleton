# Installation

Hier erfährst du, wie du das Extension Skeleton in einer TYPO3-Installation verwendest.

## Als Composer-Package

### Option 1: Lokale Installation

Wenn du das Skeleton lokal entwickelst:

```bash
cd /path/to/your/typo3/project

# Füge das lokale Package zur composer.json hinzu
composer config repositories.extension-skeleton path /path/to/extension-skeleton

# Installiere die Extension
composer require vendor/typo3-extension-skeleton
```

### Option 2: Via Git Repository

Wenn das Skeleton in einem Git-Repository ist:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/yourusername/typo3-extension-skeleton"
    }
  ],
  "require": {
    "vendor/typo3-extension-skeleton": "^1.0"
  }
}
```

Dann:

```bash
composer require vendor/typo3-extension-skeleton
```

## Extension aktivieren

Nach der Installation über Composer:

```bash
# Extension aktivieren
php vendor/bin/typo3 extension:activate extension_skeleton

# Cache leeren
php vendor/bin/typo3 cache:flush
```

## Im TYPO3 Backend

1. **Extension Manager öffnen**
   - Gehe zu "Admin Tools" → "Extensions"

2. **Extension aktivieren**
   - Suche nach "Extension Skeleton"
   - Klicke auf das Aktivieren-Icon

3. **Cache leeren**
   - "Admin Tools" → "Maintenance" → "Flush all caches"

## Plugin einbinden

### Via TypoScript

Füge das Plugin zu einer Seite hinzu:

```typoscript
page.10 = USER
page.10 {
    userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
    extensionName = ExtensionSkeleton
    pluginName = Example
}
```

### Via Backend

1. Neue Content-Element erstellen
2. Typ "Plugin" wählen
3. "Extension Skeleton - Example" auswählen

## Konfiguration

### Services.yaml anpassen

Passe `Configuration/Services.yaml` an deine Bedürfnisse an:

```yaml
services:
  _defaults:
    autowire: true
    autoconfigure: true
    public: false

  Vendor\ExtensionSkeleton\:
    resource: '../Classes/*'

  # Eigene Services
  Vendor\ExtensionSkeleton\Service\MyService:
    public: true
```

### Middleware konfigurieren

Die Middleware ist bereits in `Configuration/RequestMiddlewares.php` konfiguriert.

Um sie zu deaktivieren oder anzupassen:

```php
return [
    'frontend' => [
        'vendor/extension-skeleton/example-middleware' => [
            'target' => ExampleMiddleware::class,
            'disabled' => true, // Middleware deaktivieren
        ],
    ],
];
```

## Routing

Die Extension bringt bereits Routing-Konfiguration mit:

- `/example` → IndexAction
- `/example/{id}` → ShowAction

Eigene Routes in `Configuration/Routes/Default.yaml` hinzufügen:

```yaml
my_custom_route:
  path: /my-route
  type: plugin
  defaults:
    _controller: 'Vendor\ExtensionSkeleton\Controller\MyController::myAction'
```

## Entwicklungsmodus

### Debug-Modus aktivieren

In `config/system/settings.php`:

```php
return [
    'BE' => [
        'debug' => true,
    ],
    'FE' => [
        'debug' => true,
    ],
];
```

### Exception-Handling

Für detaillierte Fehler:

```php
return [
    'SYS' => [
        'displayErrors' => 1,
        'devIPmask' => '*',
        'exceptionalErrors' => E_ALL,
    ],
];
```

## Dokumentation deployen

### GitHub Pages

1. **GitHub Actions Workflow** (`.github/workflows/docs.yml`):

```yaml
name: Deploy Docs

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3

      - name: Setup Node
        uses: actions/setup-node@v3
        with:
          node-version: 18

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'

      - name: Install dependencies
        run: |
          composer install
          npm install

      - name: Generate docs
        run: composer docs:generate

      - name: Build docs
        run: npm run docs:build

      - name: Deploy to GitHub Pages
        uses: peaceiris/actions-gh-pages@v3
        with:
          github_token: ${{ secrets.GITHUB_TOKEN }}
          publish_dir: ./dist
```

2. **GitHub Pages aktivieren**:
   - Repository Settings → Pages
   - Source: "gh-pages" branch

### Eigener Server

```bash
# Dokumentation bauen
composer docs:generate
npm run docs:build

# Dist-Ordner auf Server kopieren
rsync -avz dist/ user@server:/var/www/docs/
```

## Troubleshooting

### Extension wird nicht gefunden

```bash
# Composer autoload neu generieren
composer dump-autoload

# Extension-Cache leeren
php vendor/bin/typo3 cache:flush
```

### Middleware funktioniert nicht

Prüfe die Reihenfolge in `Configuration/RequestMiddlewares.php`:

```bash
# Middleware-Stack anzeigen
php vendor/bin/typo3 backend:middlewares
php vendor/bin/typo3 frontend:middlewares
```

### Dokumentation generiert nicht

```bash
# Rechte prüfen
chmod +x Build/PhpDocGenerator.php

# Manuell ausführen
php Build/PhpDocGenerator.php
```

## Nächste Schritte

- [Getting Started Guide](/getting-started)
- [API-Dokumentation](/generated/index)
- Eigene Features entwickeln
