# Setting Up GitHub Pages

This guide explains how to enable GitHub Pages for your TYPO3 extension documentation.

## Prerequisites

- Repository must be public (or GitHub Pro/Team/Enterprise for private repos)
- You have admin access to the repository

## Setup Steps

### 1. Enable GitHub Pages

1. Go to your repository on GitHub
2. Click **Settings** (top navigation)
3. Click **Pages** (left sidebar under "Code and automation")
4. Under "Build and deployment":
   - **Source**: Select "GitHub Actions"
5. Click **Save**

### 2. Trigger First Deployment

The documentation will be automatically deployed when you:
- Push to `main` or `master` branch
- Modify files in `Classes/`, `docs/`, or `Build/PhpDocGenerator.php`
- Manually trigger via "Actions" tab → "Deploy Documentation" → "Run workflow"

### 3. Access Your Documentation

After the workflow completes (usually 2-3 minutes):

- Your documentation will be available at:
  ```
  https://[username].github.io/[repository-name]/
  ```

- Example:
  ```
  https://yourusername.github.io/typo3-extension-skeleton/
  ```

## How It Works

The GitHub Actions workflow (`.github/workflows/deploy-docs.yml`):

1. **Checkout** - Pulls your repository code
2. **Setup PHP 8.2** - Installs PHP for PHPDoc generation
3. **Setup Node.js 18** - Installs Node for VitePress
4. **Install Dependencies** - Runs `composer install` and `npm ci`
5. **Generate Docs** - Runs `php Build/PhpDocGenerator.php`
6. **Build VitePress** - Runs `npm run docs:build`
7. **Deploy** - Publishes `./dist` to GitHub Pages

## Workflow Files

### Deploy Documentation (`.github/workflows/deploy-docs.yml`)
- **Trigger**: Push to main/master, or manual dispatch
- **Action**: Builds and deploys to GitHub Pages
- **Output**: Live documentation site

### Preview Documentation (`.github/workflows/preview-docs.yml`)
- **Trigger**: Pull requests to main/master
- **Action**: Builds documentation preview
- **Output**: Downloadable artifact for review

## Customization

### Change Trigger Branches

Edit `.github/workflows/deploy-docs.yml`:

```yaml
on:
  push:
    branches:
      - main          # Add/remove branches
      - develop
```

### Add Custom Domain

1. In repository Settings → Pages
2. Add your custom domain
3. Configure DNS records (see GitHub docs)

### Modify Build Process

Edit the workflow file to add custom build steps:

```yaml
- name: Custom build step
  run: |
    # Your custom commands
    echo "Running custom build..."
```

## Troubleshooting

### Workflow Fails

Check the Actions tab for error logs:
1. Click **Actions** tab
2. Click the failed workflow run
3. Expand failed steps to see error messages

### Common Issues

**PHP Version Mismatch**
```yaml
# Update in deploy-docs.yml
php-version: '8.3'  # Change version
```

**Node Version Issues**
```yaml
# Update in deploy-docs.yml
node-version: '20'  # Change version
```

**Missing Dependencies**
- Ensure `composer.json` has all required packages
- Ensure `package.json` has VitePress dependency

### Page Not Found (404)

1. Check GitHub Pages settings (Settings → Pages)
2. Ensure "Source" is set to "GitHub Actions"
3. Wait 5-10 minutes after first deployment
4. Clear browser cache

### Documentation Not Updating

1. Check if workflow ran successfully (Actions tab)
2. Verify files were changed in trigger paths
3. Force trigger: Actions → Deploy Documentation → Run workflow

## Manual Deployment

If you prefer manual control:

```bash
# Local build
npm run docs:build

# Deploy dist/ folder using your preferred method
```

## Monitoring

- **Build Status**: Repository badge
  ```markdown
  ![Docs](https://github.com/username/repo/workflows/Deploy%20Documentation/badge.svg)
  ```

- **Deployment History**: Settings → Pages → "View deployments"

## Security

The workflow uses minimal permissions:
- `contents: read` - Read repository files
- `pages: write` - Deploy to GitHub Pages
- `id-token: write` - OIDC token for deployment

## Cost

GitHub Pages is **free** for:
- Public repositories (unlimited)
- Private repositories (usage limits apply)

## Next Steps

1. ✅ Enable GitHub Pages (above)
2. 📝 Customize `docs/.vitepress/config.ts`
3. 🎨 Add custom styling
4. 🔗 Add documentation badge to README

## Support

- [GitHub Pages Documentation](https://docs.github.com/pages)
- [GitHub Actions Documentation](https://docs.github.com/actions)
- [VitePress Documentation](https://vitepress.dev)
