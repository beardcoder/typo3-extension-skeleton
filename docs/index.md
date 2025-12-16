---
layout: home

hero:
  name: TYPO3 Extension Skeleton
  text: Auto-Documentation Ready
  tagline: Modern TYPO3 v13 extension skeleton with automatic documentation generation
  actions:
    - theme: brand
      text: Get Started
      link: /getting-started
    - theme: alt
      text: View API Docs
      link: /generated/index

features:
  - icon: 🚀
    title: TYPO3 v13 Ready
    details: Fully compatible with TYPO3 v13 LTS. Uses modern PHP 8.2+ features and PSR standards.

  - icon: 📝
    title: Auto-Documentation
    details: Automatically generates Markdown documentation from PHPDoc comments. Always up-to-date, always in sync with code.

  - icon: 🎨
    title: VitePress Integration
    details: Beautiful, searchable documentation with VitePress. GitHub Pages ready, fast builds.

  - icon: 🏗️
    title: Best Practices
    details: PSR-15 Middleware, Extbase Controller, Dependency Injection, Strict Types - everything follows best practices.

  - icon: 🔧
    title: Developer Friendly
    details: Makefile and Composer scripts for fast workflows. Generate and test documentation in seconds.

  - icon: 📦
    title: Production Ready
    details: Complete extension structure with all necessary configuration files. Ready to use immediately.
---

## Quick Start

```bash
# Clone the repository
git clone https://github.com/yourusername/typo3-extension-skeleton.git

# Install PHP dependencies
composer install

# Install Node dependencies for documentation
npm install

# Generate documentation from PHPDoc
composer docs:generate

# Start documentation dev server
npm run docs:dev
```

## Features in Detail

### 📦 Extension Structure

- ✅ Complete TYPO3 v13 extension following PSR-4
- ✅ composer.json with correct namespaces
- ✅ Services.yaml for Dependency Injection
- ✅ Routing configuration

### 🎯 Example Components

- ✅ PSR-15 Middleware with complete PHPDoc
- ✅ Extbase Controller with multiple actions
- ✅ Fluid Templates with Layouts and Partials
- ✅ CSS/JS Integration

### 📚 Documentation

- ✅ Automatic PHPDoc parser
- ✅ Markdown generation
- ✅ VitePress integration
- ✅ Searchable API reference

## Developer Workflow

```bash
# Generate documentation
make docs
# or: composer docs:generate

# Start dev server
make docs-serve
# or: npm run docs:dev

# Build documentation
make docs-build
# or: npm run docs:build
```

## Customization

1. **Change namespace**: Replace `Vendor\ExtensionSkeleton` in all files
2. **Change extension key**: Adjust `extension_skeleton`
3. **Add PHPDoc**: Document your classes and methods
4. **Generate documentation**: Run `composer docs:generate`

## License

GPL-2.0-or-later
