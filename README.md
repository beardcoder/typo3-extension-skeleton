# TYPO3 v13 Extension Skeleton

🚀 Modern, reusable skeleton for TYPO3 v13 extensions with integrated **auto-documentation**.

[![TYPO3](https://img.shields.io/badge/TYPO3-v13-orange.svg)](https://get.typo3.org/version/13)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-GPL--2.0--or--later-green.svg)](LICENSE)
[![Deploy Docs](https://github.com/yourusername/typo3-extension-skeleton/workflows/Deploy%20Documentation%20to%20GitHub%20Pages/badge.svg)](https://github.com/yourusername/typo3-extension-skeleton/actions)

## ✨ Features

- ✅ **TYPO3 v13 compatible** - Full support for TYPO3 v13 LTS
- ✅ **Auto-Documentation** - Generates Markdown docs from PHPDoc automatically
- ✅ **VitePress Integration** - Beautiful, searchable documentation
- ✅ **PSR-15 Middleware** - Example middleware with complete documentation
- ✅ **Extbase Controller** - Modern controller with Dependency Injection
- ✅ **PHP 8.2+** - Uses modern PHP features (Strict Types, Constructor Property Promotion)
- ✅ **Best Practices** - PSR-4, PSR-15, Dependency Injection, Clean Code
- ✅ **Developer Friendly** - Makefile and Composer scripts for fast workflow

## 📦 What's Included?

### Extension Structure

```
typo3-extension-skeleton/
├── Classes/
│   ├── Controller/
│   │   └── ExampleController.php          # Extbase Controller with 2 actions
│   └── Middleware/
│       └── ExampleMiddleware.php          # PSR-15 Middleware
├── Configuration/
│   ├── RequestMiddlewares.php             # Middleware registration
│   ├── Routes/Default.yaml                # Routing configuration
│   └── Services.yaml                      # DI Container config
├── Resources/
│   ├── Private/
│   │   ├── Templates/Example/             # Fluid Templates
│   │   ├── Layouts/                       # Fluid Layouts
│   │   └── Partials/                      # Fluid Partials
│   └── Public/Css/                        # Styles
├── Build/
│   └── PhpDocGenerator.php                # 🎯 PHPDoc → Markdown Generator
├── docs/
│   ├── .vitepress/config.ts               # VitePress Config
│   ├── index.md                           # Docs Homepage
│   ├── getting-started.md                 # Getting Started Guide
│   ├── installation.md                    # Installation Guide
│   └── generated/                         # 📝 Auto-generated docs
├── composer.json
├── ext_emconf.php
├── ext_localconf.php
├── package.json
├── Makefile                               # 🛠️ Developer commands
└── README.md
```

### Example Components

#### 1. PSR-15 Middleware
```php
class ExampleMiddleware implements MiddlewareInterface
{
    /**
     * Processes an incoming server request
     *
     * This method is called for every request and allows you to
     * modify the request or return an early response.
     *
     * @param ServerRequestInterface $request The incoming HTTP request
     * @param RequestHandlerInterface $handler The next request handler
     * @return ResponseInterface The HTTP response
     * @throws \RuntimeException If request processing fails
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // ... Implementation
    }
}
```

#### 2. Extbase Controller
```php
class ExampleController extends ActionController
{
    /**
     * Index Action - List view
     *
     * This action displays a list of example data.
     *
     * @return ResponseInterface The rendered response
     * @throws \RuntimeException If template is not found
     */
    public function indexAction(): ResponseInterface
    {
        // ... Implementation
    }
}
```

## 🚀 Quick Start

### 1. Installation

```bash
# Clone repository or use as template
git clone https://github.com/yourusername/typo3-extension-skeleton.git my-extension
cd my-extension

# Install dependencies
make install
# or:
composer install && npm install
```

### 2. Customize Namespace

Replace in all files:
- `Vendor\ExtensionSkeleton` → `YourVendor\YourExtension`
- `extension_skeleton` → `your_extension_key`

### 3. Generate Documentation

```bash
# Generate documentation from PHPDoc
make docs

# Start dev server
make docs-serve
```

Open http://localhost:5173 - done! 🎉

## 📝 Documentation Pipeline

### How It Works

1. **Write PHPDoc** - Document your classes and methods with PHPDoc:
```php
/**
 * Method description
 *
 * @param string $param Parameter description
 * @return array The result
 * @throws \Exception When something goes wrong
 */
public function myMethod(string $param): array
```

2. **Generate Documentation** - One command:
```bash
make docs
# or: composer docs:generate
```

3. **Result** - Automatically generated Markdown files in `docs/generated/`:
   - `index.md` - Overview of all classes
   - `Vendor_ExtensionSkeleton_Controller_ExampleController.md` - Class details
   - `api-reference.md` - Complete API reference

4. **VitePress** - Displays the documentation beautifully formatted

### Developer Workflow

```bash
# Setup (one-time)
make setup

# Develop documentation
make docs-serve      # Starts dev server with hot-reload

# For production
make docs-build      # Builds static site in ./dist

# Tests & Quality
make test           # PHPStan
make cs-fix         # PHP CS Fixer
```

## 🛠️ Makefile Commands

```bash
make help           # Shows all available commands
make install        # Installs all dependencies
make docs           # Generates documentation from PHPDoc
make docs-serve     # Starts VitePress dev server
make docs-build     # Builds static documentation
make docs-preview   # Preview of built docs
make clean          # Deletes generated files
make test           # Runs tests
make setup          # Complete setup
```

## 🚀 CI/CD - GitHub Actions

### Automatic Documentation Deployment

The repository includes GitHub Actions workflows for automatic documentation generation and deployment:

**On Push to Main/Master:**
- Automatically generates docs from PHPDoc
- Builds VitePress static site
- Deploys to GitHub Pages

**On Pull Requests:**
- Generates documentation preview
- Creates downloadable artifact
- Comments on PR with status

**Setup Instructions:**
See [.github/SETUP_GITHUB_PAGES.md](.github/SETUP_GITHUB_PAGES.md) for detailed setup guide.

## 📚 Usage in TYPO3

### As Composer Package

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

```bash
composer require vendor/typo3-extension-skeleton
php vendor/bin/typo3 extension:activate extension_skeleton
php vendor/bin/typo3 cache:flush
```

### As Template

1. Use this repository as GitHub template
2. Clone your new repository
3. Customize namespace and extension key
4. Develop your extension
5. Generate documentation with `make docs`

## 🎯 Best Practices

### PHPDoc Comments

✅ **Good:**
```php
/**
 * Gets user by ID
 *
 * This method loads a user from the database.
 * Returns null if the user is not found.
 *
 * @param int $id The user ID
 * @return User|null The found user or null
 * @throws \InvalidArgumentException If the ID is invalid
 */
public function getUserById(int $id): ?User
```

❌ **Bad:**
```php
// Gets user
public function getUserById(int $id): ?User
```

### Dependency Injection

✅ **TYPO3 v13 Style:**
```php
public function __construct(
    private readonly MyService $myService,
    private readonly PageRenderer $pageRenderer
) {
}
```

### Strict Types

Use `declare(strict_types=1);` in every PHP file.

## 📖 Documentation

The complete documentation is automatically generated and available at:
- **Local:** http://localhost:5173 (after `make docs-serve`)
- **GitHub Pages:** https://yourusername.github.io/typo3-extension-skeleton

### Documentation Structure

- **Getting Started** - First steps and setup
- **Installation** - Integration in TYPO3
- **API Documentation** - Auto-generated class docs
- **Complete Reference** - Full API overview

### GitHub Pages Deployment

Documentation is automatically deployed to GitHub Pages via GitHub Actions:

1. **Enable GitHub Pages**: See [Setup Guide](.github/SETUP_GITHUB_PAGES.md)
2. **Automatic Deployment**: Triggered on push to `main`/`master`
3. **PR Previews**: Built on pull requests for review

**Workflows:**
- `.github/workflows/deploy-docs.yml` - Deploys to GitHub Pages
- `.github/workflows/preview-docs.yml` - Builds preview for PRs

## 🔧 Customization

### 1. Extension Information

**composer.json:**
```json
{
  "name": "your-vendor/your-extension",
  "description": "Your extension description"
}
```

**ext_emconf.php:**
```php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Your Extension',
    'description' => 'Description',
    'author' => 'Your Name',
];
```

### 2. Namespace

Replace everywhere:
- `Vendor\ExtensionSkeleton` → `YourVendor\YourExtension`
- `extension_skeleton` → `your_extension_key`

### 3. VitePress Config

**docs/.vitepress/config.ts:**
```typescript
export default defineConfig({
  title: 'Your Extension',
  description: 'Your Description',
  // ...
})
```

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

GPL-2.0-or-later - see [LICENSE](LICENSE)

## 🙏 Credits

- TYPO3 CMS - https://typo3.org
- VitePress - https://vitepress.dev
- PSR-15 - https://www.php-fig.org/psr/psr-15/

## 📞 Support

- **Issues:** https://github.com/yourusername/typo3-extension-skeleton/issues
- **Discussions:** https://github.com/yourusername/typo3-extension-skeleton/discussions
- **TYPO3 Slack:** #ext-yourextension

---

**Happy Coding!** 🚀

Created with ❤️ for the TYPO3 Community
