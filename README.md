# TYPO3 v13 Extension Skeleton

Modern skeleton for TYPO3 v13 extensions with phpDocumentor documentation.

[![TYPO3](https://img.shields.io/badge/TYPO3-v13-orange.svg)](https://get.typo3.org/version/13)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net/)

## Features

- TYPO3 v13 compatible
- phpDocumentor integration for API documentation
- Example PSR-15 Middleware
- Example Extbase Controller
- Modern PHP 8.2+ with strict types
- GitHub Actions workflows for docs deployment

## Quick Start

```bash
# Clone or use as template
git clone https://github.com/yourusername/typo3-extension-skeleton.git my-extension
cd my-extension

# Install dependencies
composer install && npm install

# Generate and view documentation
composer docs:generate
npm run docs:dev
```

## Customization

Replace in all files:
- `Vendor\ExtensionSkeleton` → `YourVendor\YourExtension`
- `extension_skeleton` → `your_extension_key`
- Update `composer.json` and `ext_emconf.php`

## Commands

```bash
make install        # Install dependencies
make docs           # Generate documentation with phpDocumentor
make docs-serve     # Start dev server (http://localhost:5173)
make docs-build     # Build static documentation
make test           # Run PHPStan
make cs-fix         # Run PHP CS Fixer
```

## Structure

```
├── Classes/                # Extension PHP classes
├── Configuration/          # TYPO3 configuration
├── Resources/             # Templates, assets
├── docs/                  # VitePress documentation
└── Makefile              # Developer commands
```

## License

GPL-2.0-or-later
