import { defineConfig } from "vitepress";
import { readdirSync, statSync } from "fs";
import { join } from "path";

/**
 * VitePress Configuration for TYPO3 Extension Skeleton
 *
 * This configuration is automatically loaded and generates
 * the sidebar navigation from the generated Markdown files.
 */

/**
 * Recursive function to scan directories and create sidebar items
 */
function getSidebarItems(dir: string, basePath: string = ""): any[] {
  try {
    const items: any[] = [];
    const files = readdirSync(dir);

    // Sort files and folders
    const sorted = files.sort((a, b) => {
      const aPath = join(dir, a);
      const bPath = join(dir, b);
      const aIsDir = statSync(aPath).isDirectory();
      const bIsDir = statSync(bPath).isDirectory();

      // Folders first, then alphabetically
      if (aIsDir && !bIsDir) return -1;
      if (!aIsDir && bIsDir) return 1;
      return a.localeCompare(b);
    });

    for (const file of sorted) {
      const filePath = join(dir, file);
      const stat = statSync(filePath);
      const relativePath = basePath ? `${basePath}/${file}` : file;

      if (stat.isDirectory()) {
        // Recursively scan subdirectories
        const children = getSidebarItems(filePath, relativePath);
        if (children.length > 0) {
          items.push({
            text: file,
            collapsed: false,
            items: children,
          });
        }
      } else if (file.endsWith(".md")) {
        // Add markdown file to sidebar
        const name = file.replace(".md", "");
        items.push({
          text: name,
          link: `/classes/${relativePath.replace(".md", "")}`,
        });
      }
    }

    return items;
  } catch (err) {
    console.log(
      "Generated docs not yet available, run: composer docs:generate"
    );
    return [];
  }
}

/**
 * Generates the complete sidebar structure
 */
function generateSidebar() {
  const classesPath = join(__dirname, "../classes");

  try {
    return [
      {
        text: "Overview",
        items: [
          { text: "Home", link: "/" },
          { text: "API Overview", link: "/Home" },
        ],
      },
      {
        text: "Classes",
        collapsed: false,
        items: getSidebarItems(classesPath),
      },
    ];
  } catch (err) {
    return [
      {
        text: "Overview",
        items: [
          { text: "Home", link: "/" },
          { text: "API Overview", link: "/Home" },
        ],
      },
    ];
  }
}

export default defineConfig({
  title: "TYPO3 Extension Skeleton",
  description: "Auto-generated documentation for TYPO3 v13 Extension Skeleton",
  base: "/typo3-extension-skeleton/",

  // Theme config
  themeConfig: {
    logo: "/logo.svg",

    nav: [
      { text: "Home", link: "/" },
      { text: "API Overview", link: "/Home" },
      {
        text: "GitHub",
        link: "https://github.com/beardcoder/typo3-extension-skeleton",
      },
    ],

    sidebar: generateSidebar(),

    socialLinks: [
      {
        icon: "github",
        link: "https://github.com/beardcoder/typo3-extension-skeleton",
      },
    ],

    // Outline in sidebar
    outline: {
      level: [2, 3],
      label: "On this page",
    },

    // Documentation footer navigation
    docFooter: {
      prev: "Previous page",
      next: "Next page",
    },

    // Dark mode label
    darkModeSwitchLabel: "Appearance",
    sidebarMenuLabel: "Menu",
    returnToTopLabel: "Return to top",

    search: {
      provider: "local",
    },

    footer: {
      message: "Released under the GPL-2.0-or-later License.",
      copyright: "Copyright © 2025 TYPO3 Extension Skeleton",
    },
  },

  // Markdown config
  markdown: {
    lineNumbers: true,
    theme: {
      light: "github-light",
      dark: "github-dark",
    },
  },

  // Build config
  outDir: "./.vitepress/dist",
  cacheDir: "./.vitepress/cache",

  // Last updated
  lastUpdated: true,

  // Clean URLs
  cleanUrls: true,

  // Ignore dead links to external classes
  ignoreDeadLinks: [
    // Ignore links to PHP standard exceptions
    /RuntimeException/,
    /InvalidArgumentException/,
    /Exception/,
    // Ignore links to TYPO3 core classes
    /TYPO3\/CMS\//,
    // Ignore any relative paths that go up multiple levels (external class references)
    /\.\.\/\.\.\/\.\.\//,
  ],
});
