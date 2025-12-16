.PHONY: help install docs docs-serve docs-build clean test

# Default target
.DEFAULT_GOAL := help

## help: Shows this help message
help:
	@echo "╔════════════════════════════════════════════════════════════╗"
	@echo "║  TYPO3 Extension Skeleton - Makefile Commands             ║"
	@echo "╚════════════════════════════════════════════════════════════╝"
	@echo ""
	@echo "Available commands:"
	@echo ""
	@grep -E '^## ' Makefile | sed 's/## /  /'
	@echo ""

## install: Installs all dependencies (Composer + npm)
install:
	@echo "📦 Installing dependencies..."
	composer install
	npm install
	@echo "✅ Dependencies installed!"

## docs: Generates documentation from PHPDoc
docs:
	@echo "📝 Generating documentation from PHPDoc..."
	php Build/PhpDocGenerator.php
	@echo "✅ Documentation generated!"

## docs-serve: Starts the VitePress dev server
docs-serve: docs
	@echo "🚀 Starting VitePress dev server..."
	@echo "📖 Open http://localhost:5173 in your browser"
	cd docs && npm run docs:dev

## docs-build: Builds static documentation
docs-build: docs
	@echo "🏗️  Building static documentation..."
	npm run docs:build
	@echo "✅ Documentation built in ./dist"

## docs-preview: Preview of built documentation
docs-preview: docs-build
	@echo "👀 Previewing built documentation..."
	npm run docs:preview

## clean: Deletes generated files and caches
clean:
	@echo "🧹 Cleaning up..."
	rm -rf docs/generated/*
	rm -rf dist
	rm -rf docs/.vitepress/cache
	rm -rf node_modules/.vite
	@echo "✅ Cleaned!"

## test: Runs tests (phpstan, php-cs-fixer)
test:
	@echo "🧪 Running tests..."
	@if [ -f vendor/bin/phpstan ]; then \
		echo "Running PHPStan..."; \
		vendor/bin/phpstan analyse Classes; \
	else \
		echo "⚠️  PHPStan not installed. Run: composer require --dev phpstan/phpstan"; \
	fi
	@echo "✅ Tests completed!"

## cs-fix: Runs PHP CS Fixer
cs-fix:
	@echo "🔧 Running PHP CS Fixer..."
	@if [ -f vendor/bin/php-cs-fixer ]; then \
		vendor/bin/php-cs-fixer fix; \
	else \
		echo "⚠️  PHP CS Fixer not installed. Run: composer require --dev friendsofphp/php-cs-fixer"; \
	fi

## setup: Complete setup (install + docs)
setup: install docs
	@echo ""
	@echo "✨ Setup complete!"
	@echo ""
	@echo "Next steps:"
	@echo "  1. Run 'make docs-serve' to view the documentation"
	@echo "  2. Customize the extension for your needs"
	@echo "  3. Run 'make docs' after changing PHPDoc comments"
	@echo ""

## dev: Starts development mode (watch + serve)
dev:
	@echo "🔥 Starting development mode..."
	@echo "Docs will be regenerated and served..."
	@make docs-serve
