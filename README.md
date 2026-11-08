# PortfolioWind — Modern Single-Page Portfolio WordPress Theme

**PortfolioWind** is a modern, zero-bloat, high-performance WordPress portfolio theme engineered for software engineers, product designers, and full-stack developers. Built with utility-first Tailwind CSS, lightweight Vanilla JavaScript, and native WordPress APIs.

## Key Features

- **Blazing Fast Performance**: Zero jQuery overhead on front-end, highly optimized assets, sub-second load times.
- **Tailwind CSS Styling**: Utility-first architecture with native JIT pipeline support (`npm run build`).
- **Dark Mode Engine**: Instant anti-flicker theme toggle with system preference detection (`prefers-color-scheme`).
- **Responsive Floating Navigation**: Sticky header with touch-friendly mobile drawer menu and accessible search.
- **PortfolioWind Studio**: Built-in visual dashboard for non-technical users to configure bio, experience, services, and brand color presets without page builders.
- **Elementor Canvas Compatible**: Full-width canvas template support for custom Elementor sections.
- **Accessible & SEO Ready**: Semantic HTML5 markup, WCAG 2.2 compliant color contrast, schema breadcrumb hierarchy.

## Recommended Companion Plugin

For custom case studies, outcome KPIs, and Elementor shortcodes, install the official companion plugin:
**[PortfolioWind Core](https://github.com/Muquarrabin/portfoliowind-core)**.

## Installation

1. Download or clone this repository into `/wp-content/themes/portfoliowind`:
   ```bash
   cd wp-content/themes/
   git clone https://github.com/Muquarrabin/portfoliowind-theme.git portfoliowind
   ```
2. In your WordPress admin dashboard, navigate to **Appearance > Themes**.
3. Locate **PortfolioWind** and click **Activate**.
4. Configure your portfolio via **PortfolioWind Studio** in the admin sidebar.

## Development

To customize Tailwind CSS classes and rebuild production stylesheets:

```bash
# Install dependencies
npm install

# Watch mode during development
npm run dev

# Compile minified production CSS
npm run build
```

## Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher
- Modern web browser with ES6 support

## License

PortfolioWind is open-source software licensed under the [GNU General Public License v2.0 or later](LICENSE.md).

## Author

Created with care by **[Nasif Muquarrabin](https://nasifmuquarrabin.me)**.
