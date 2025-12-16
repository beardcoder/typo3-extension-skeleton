---
layout: home

hero:
    name: TYPO3 Extension Skeleton
    text: Modern TYPO3 v13 Extension
    tagline: With phpDocumentor integration and best practices
    actions:
        - theme: brand
          text: API Overview
          link: /Home
        - theme: alt
          text: View on GitHub
          link: https://github.com/beardcoder/typo3-extension-skeleton

features:
    - icon: 📚
      title: phpDocumentor Integration
      details: Generate comprehensive API documentation using phpDocumentor
    - icon: ⚡
      title: TYPO3 v13
      details: Ready for TYPO3 v13 with PSR-15 Middlewares and modern Extbase
    - icon: 🎨
      title: Best Practices
      details: Follows TYPO3 Coding Guidelines and modern PHP standards
    - icon: 🔧
      title: Developer Tools
      details: Integrated with PHPStan, PHP-CS-Fixer and automated code quality
    - icon: 📦
      title: PSR Standards
      details: Implements PSR-15 for Middlewares and PSR-3 for Logging
    - icon: 🚀
      title: Quick Start
      details: Ready to use with pre-configured setup
---

## Quick Start

### Installation

```bash
composer require vendor/typo3-extension-skeleton
```

### Generate Documentation

```bash
# Generate phpDocumentor documentation
composer docs:generate

# Start development server
npm run docs:dev

# Create production build
npm run docs:build
```

### Code Quality

```bash
# Run PHPStan
composer phpstan

# Fix code style
composer cs-fix
```

## Project Structure

```
Classes/
├── Controller/         # Extbase Controllers
│   └── ExampleController.php
└── Middleware/        # PSR-15 Middlewares
    └── ExampleMiddleware.php

Configuration/
├── RequestMiddlewares.php
├── Services.yaml
└── Routes/

Resources/
├── Private/
│   ├── Layouts/
│   └── Templates/
└── Public/
    └── Css/
```

## Features

### Controller

The `ExampleController` demonstrates the implementation of a modern TYPO3 v13 Extbase Controller with complete PHPDoc documentation.

### Middleware

The `ExampleMiddleware` demonstrates the integration of PSR-15 Middlewares in TYPO3 with Request/Response handling and Logging.

## Further Information

-   [TYPO3 Documentation](https://docs.typo3.org)
-   [GitHub Repository](https://github.com/beardcoder/typo3-extension-skeleton)
-   [TYPO3 Extension Repository](https://extensions.typo3.org)
