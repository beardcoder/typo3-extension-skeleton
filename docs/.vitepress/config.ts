import { defineConfig } from 'vitepress'
import { readdirSync } from 'fs'
import { join } from 'path'

/**
 * VitePress Configuration für TYPO3 Extension Skeleton
 *
 * Diese Konfiguration wird automatisch geladen und generiert
 * die Sidebar-Navigation aus den generierten Markdown-Dateien.
 */

/**
 * Generiert Sidebar-Items aus dem generated Verzeichnis
 */
function getGeneratedDocsItems() {
  const generatedPath = join(__dirname, '../generated')

  try {
    const files = readdirSync(generatedPath)

    return files
      .filter(file => file.endsWith('.md') && file !== 'index.md')
      .map(file => {
        const name = file.replace('.md', '').replace(/_/g, '\\')
        return {
          text: name.split('\\').pop() || name,
          link: `/generated/${file.replace('.md', '')}`
        }
      })
      .sort((a, b) => a.text.localeCompare(b.text))
  } catch (err) {
    console.log('Generated docs not yet available, run: composer docs:generate')
    return []
  }
}

export default defineConfig({
  title: 'TYPO3 Extension Skeleton',
  description: 'Auto-generated documentation for TYPO3 v13 Extension Skeleton',

  // Theme config
  themeConfig: {
    logo: '/logo.svg',

    nav: [
      { text: 'Home', link: '/' },
      { text: 'API Docs', link: '/generated/index' },
      { text: 'GitHub', link: 'https://github.com/yourusername/typo3-extension-skeleton' }
    ],

    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'Getting Started', link: '/getting-started' },
          { text: 'Installation', link: '/installation' }
        ]
      },
      {
        text: 'API Documentation',
        items: [
          { text: 'Overview', link: '/generated/index' },
          { text: 'Complete Reference', link: '/generated/api-reference' }
        ]
      },
      {
        text: 'Classes',
        items: getGeneratedDocsItems(),
        collapsed: false
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/yourusername/typo3-extension-skeleton' }
    ],

    search: {
      provider: 'local'
    },

    footer: {
      message: 'Released under the GPL-2.0-or-later License.',
      copyright: 'Copyright © 2025 TYPO3 Extension Skeleton'
    }
  },

  // Markdown config
  markdown: {
    lineNumbers: true,
    theme: {
      light: 'github-light',
      dark: 'github-dark'
    }
  },

  // Build config
  outDir: '../dist',
  cacheDir: '../.vitepress/cache',

  // Last updated
  lastUpdated: true,

  // Clean URLs
  cleanUrls: true
})
