<?php

declare(strict_types=1);

/**
 * PHPDoc to Markdown Generator
 *
 * Dieses Script parst alle PHP-Dateien im Classes-Verzeichnis und generiert
 * automatisch Markdown-Dokumentation aus den PHPDoc-Blöcken.
 *
 * Verwendung:
 *   php Build/PhpDocGenerator.php
 *   composer docs:generate
 *
 * @author Your Name <your.email@example.com>
 * @license GPL-2.0-or-later
 */

class PhpDocGenerator
{
    private const CLASSES_DIR = __DIR__ . '/../Classes';
    private const DOCS_DIR = __DIR__ . '/../docs/generated';

    private array $classes = [];

    public function __construct()
    {
        $this->ensureDocsDirectory();
    }

    /**
     * Hauptmethode zur Dokumentationsgenerierung
     */
    public function generate(): void
    {
        echo "🔍 Scanning PHP files...\n";
        $this->scanClasses();

        echo "📝 Generating documentation...\n";
        $this->generateClassDocs();
        $this->generateIndex();
        $this->generateApiReference();

        echo "✅ Documentation generated successfully in " . self::DOCS_DIR . "\n";
    }

    /**
     * Scannt alle PHP-Klassen im Classes-Verzeichnis
     */
    private function scanClasses(): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::CLASSES_DIR)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $this->parseClassFile($file->getPathname());
            }
        }

        echo "   Found " . count($this->classes) . " classes\n";
    }

    /**
     * Parst eine einzelne PHP-Datei
     */
    private function parseClassFile(string $filePath): void
    {
        $content = file_get_contents($filePath);
        $tokens = token_get_all($content);

        $namespace = '';
        $className = '';
        $classDoc = '';
        $methods = [];
        $currentMethodDoc = '';
        $inClass = false;

        for ($i = 0; $i < count($tokens); $i++) {
            $token = $tokens[$i];

            if (is_array($token)) {
                // Namespace extrahieren
                if ($token[0] === T_NAMESPACE) {
                    $namespace = $this->extractNamespace($tokens, $i);
                }

                // DocBlock für Klasse oder Methode
                if ($token[0] === T_DOC_COMMENT) {
                    $docComment = $token[1];

                    // Nächsten Token prüfen
                    $nextToken = $this->getNextSignificantToken($tokens, $i);

                    if ($nextToken[0] === T_CLASS) {
                        $classDoc = $docComment;
                    } elseif ($nextToken[0] === T_PUBLIC || $nextToken[0] === T_PRIVATE || $nextToken[0] === T_PROTECTED) {
                        $currentMethodDoc = $docComment;
                    }
                }

                // Klasse gefunden
                if ($token[0] === T_CLASS) {
                    $className = $this->getNextIdentifier($tokens, $i);
                    $inClass = true;
                }

                // Methode gefunden
                if ($inClass && $token[0] === T_FUNCTION) {
                    $methodName = $this->getNextIdentifier($tokens, $i);
                    $methods[] = [
                        'name' => $methodName,
                        'doc' => $currentMethodDoc,
                    ];
                    $currentMethodDoc = '';
                }
            }
        }

        if ($className) {
            $this->classes[] = [
                'namespace' => $namespace,
                'className' => $className,
                'fullClassName' => $namespace ? $namespace . '\\' . $className : $className,
                'doc' => $classDoc,
                'methods' => $methods,
                'file' => $filePath,
            ];
        }
    }

    /**
     * Extrahiert den Namespace aus Tokens
     */
    private function extractNamespace(array $tokens, int $startIndex): string
    {
        $namespace = '';
        for ($i = $startIndex + 1; $i < count($tokens); $i++) {
            if (is_array($tokens[$i])) {
                if ($tokens[$i][0] === T_STRING || $tokens[$i][0] === T_NS_SEPARATOR) {
                    $namespace .= $tokens[$i][1];
                }
            } elseif ($tokens[$i] === ';') {
                break;
            }
        }
        return trim($namespace);
    }

    /**
     * Holt den nächsten Identifier (Name)
     */
    private function getNextIdentifier(array $tokens, int $startIndex): string
    {
        for ($i = $startIndex + 1; $i < count($tokens); $i++) {
            if (is_array($tokens[$i]) && $tokens[$i][0] === T_STRING) {
                return $tokens[$i][1];
            }
        }
        return '';
    }

    /**
     * Holt den nächsten signifikanten Token (kein Whitespace)
     */
    private function getNextSignificantToken(array $tokens, int $startIndex): array
    {
        for ($i = $startIndex + 1; $i < count($tokens); $i++) {
            if (is_array($tokens[$i]) && $tokens[$i][0] !== T_WHITESPACE) {
                return $tokens[$i];
            }
        }
        return [T_WHITESPACE, '', 0];
    }

    /**
     * Generiert Markdown-Dateien für alle Klassen
     */
    private function generateClassDocs(): void
    {
        foreach ($this->classes as $class) {
            $this->generateClassMarkdown($class);
        }
    }

    /**
     * Generiert Markdown für eine einzelne Klasse
     */
    private function generateClassMarkdown(array $class): void
    {
        $markdown = "# {$class['className']}\n\n";
        $markdown .= "**Namespace:** `{$class['namespace']}`\n\n";
        $markdown .= "**Full Class Name:** `{$class['fullClassName']}`\n\n";

        // Klassen-Dokumentation
        if ($class['doc']) {
            $parsedDoc = $this->parseDocBlock($class['doc']);
            $markdown .= "## Description\n\n";
            $markdown .= $parsedDoc['description'] . "\n\n";

            if (!empty($parsedDoc['tags'])) {
                $markdown .= "### Tags\n\n";
                foreach ($parsedDoc['tags'] as $tag => $values) {
                    foreach ($values as $value) {
                        $markdown .= "- **@{$tag}** {$value}\n";
                    }
                }
                $markdown .= "\n";
            }
        }

        // Methoden
        if (!empty($class['methods'])) {
            $markdown .= "## Methods\n\n";

            foreach ($class['methods'] as $method) {
                $markdown .= "### `{$method['name']}()`\n\n";

                if ($method['doc']) {
                    $parsedDoc = $this->parseDocBlock($method['doc']);

                    if ($parsedDoc['description']) {
                        $markdown .= $parsedDoc['description'] . "\n\n";
                    }

                    // Parameter
                    if (isset($parsedDoc['tags']['param'])) {
                        $markdown .= "**Parameters:**\n\n";
                        foreach ($parsedDoc['tags']['param'] as $param) {
                            $markdown .= "- `{$param}`\n";
                        }
                        $markdown .= "\n";
                    }

                    // Return
                    if (isset($parsedDoc['tags']['return'])) {
                        $markdown .= "**Returns:** `{$parsedDoc['tags']['return'][0]}`\n\n";
                    }

                    // Throws
                    if (isset($parsedDoc['tags']['throws'])) {
                        $markdown .= "**Throws:**\n\n";
                        foreach ($parsedDoc['tags']['throws'] as $throws) {
                            $markdown .= "- `{$throws}`\n";
                        }
                        $markdown .= "\n";
                    }
                }

                $markdown .= "---\n\n";
            }
        }

        // Datei speichern
        $filename = str_replace('\\', '_', $class['fullClassName']) . '.md';
        file_put_contents(self::DOCS_DIR . '/' . $filename, $markdown);
    }

    /**
     * Parst einen DocBlock
     */
    private function parseDocBlock(string $docBlock): array
    {
        $lines = explode("\n", $docBlock);
        $description = [];
        $tags = [];
        $inDescription = true;

        foreach ($lines as $line) {
            $line = trim($line);
            $line = preg_replace('/^\/\*\*|\*\/|\*/', '', $line);
            $line = trim($line);

            if (empty($line)) {
                continue;
            }

            // Tag-Zeile
            if (str_starts_with($line, '@')) {
                $inDescription = false;
                preg_match('/@(\w+)\s+(.*)/', $line, $matches);
                if ($matches) {
                    $tagName = $matches[1];
                    $tagValue = $matches[2] ?? '';
                    $tags[$tagName][] = $tagValue;
                }
            } elseif ($inDescription) {
                $description[] = $line;
            }
        }

        return [
            'description' => implode("\n", $description),
            'tags' => $tags,
        ];
    }

    /**
     * Generiert die Index-Seite
     */
    private function generateIndex(): void
    {
        $markdown = "# API Documentation\n\n";
        $markdown .= "Auto-generated documentation from PHPDoc comments.\n\n";
        $markdown .= "## Available Classes\n\n";

        // Nach Namespace gruppieren
        $byNamespace = [];
        foreach ($this->classes as $class) {
            $namespace = $class['namespace'] ?: 'Global';
            $byNamespace[$namespace][] = $class;
        }

        foreach ($byNamespace as $namespace => $classes) {
            $markdown .= "### {$namespace}\n\n";
            foreach ($classes as $class) {
                $filename = str_replace('\\', '_', $class['fullClassName']) . '.md';
                $markdown .= "- [{$class['className']}](./{$filename})\n";
            }
            $markdown .= "\n";
        }

        file_put_contents(self::DOCS_DIR . '/index.md', $markdown);
    }

    /**
     * Generiert eine vollständige API-Referenz
     */
    private function generateApiReference(): void
    {
        $markdown = "# Complete API Reference\n\n";
        $markdown .= "Complete overview of all classes, methods, and their documentation.\n\n";

        foreach ($this->classes as $class) {
            $markdown .= "## {$class['fullClassName']}\n\n";

            if ($class['doc']) {
                $parsedDoc = $this->parseDocBlock($class['doc']);
                $markdown .= $parsedDoc['description'] . "\n\n";
            }

            if (!empty($class['methods'])) {
                $markdown .= "**Methods:**\n\n";
                foreach ($class['methods'] as $method) {
                    $markdown .= "- `{$method['name']}()`\n";
                }
                $markdown .= "\n";
            }

            $markdown .= "---\n\n";
        }

        file_put_contents(self::DOCS_DIR . '/api-reference.md', $markdown);
    }

    /**
     * Stellt sicher, dass das Dokumentations-Verzeichnis existiert
     */
    private function ensureDocsDirectory(): void
    {
        if (!is_dir(self::DOCS_DIR)) {
            mkdir(self::DOCS_DIR, 0755, true);
        }
    }
}

// Script ausführen
if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "╔════════════════════════════════════════════╗\n";
    echo "║  PHPDoc to Markdown Generator             ║\n";
    echo "║  TYPO3 Extension Skeleton                 ║\n";
    echo "╚════════════════════════════════════════════╝\n";
    echo "\n";

    $generator = new PhpDocGenerator();
    $generator->generate();

    echo "\n✨ Done!\n\n";
}
