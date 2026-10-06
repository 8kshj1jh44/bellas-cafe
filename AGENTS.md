# AGENTS.md — Bella's Cafe Website (WordPress / Astra Child Theme)

Working notes for coding agents (and humans) contributing to this repository.

## 1. Infrastructure & Environment

- **Stack**: Docker Compose (WordPress:latest + MySQL 8.0) — see `docker-compose.yml`
- **Local URL**: http://localhost:8081
- **Theme root**: mounted locally at `./themes` → `/var/www/html/wp-content/themes`
- **Active theme**: Astra Child (`./themes/astra-child`)
- **Parent theme**: Astra (`./themes/astra` — gitignored; fetch per README quick start)
- **Page builder**: Elementor (visual page composition; dynamic markup lives in the child theme)
- **PHP version**: 8.0+ (strict typing, no undefined constants in ternary/coalescing)

## 2. Directory structure

```text
.
├── docker-compose.yml
├── themes/
│   ├── astra/           # parent (untracked)
│   └── astra-child/     # all custom code
│       ├── style.css    # design tokens + menu styling
│       └── functions.php
└── AGENTS.md
```

## 3. Constraints

1. PHP 8.0+ compatibility (avoid undefined constants).
2. Modern semantic HTML5 and vanilla JavaScript or native WordPress hooks.
3. Styling must use the CSS variables defined in `themes/astra-child/style.css`
   (`--bella-green`, `--bella-gold`, `--bella-cream`, `--bella-text`, `--bella-border`).
4. Files in `./themes/astra-child` auto-sync with the running Docker container at port 8081.
5. Menu content is data-driven: edit the `$menu_data` array in `functions.php`,
   rendered anywhere via the `[cafe_menu]` shortcode (e.g., Elementor Shortcode widget).

## 4. Prompting format for follow-up tasks

Feed agents a strict Role-Context-Task-Constraint prompt:

```text
You are an expert full-stack WordPress developer working on an Astra child theme.

Context:
- Read AGENTS.md for environmental setup, container mappings, design tokens, and existing architecture.
- All code resides in ./themes/astra-child/.

Task:
[e.g. "Build an online table reservation form or custom post type for daily specials
matching the Bella's Cafe palette."]

Constraints:
1. PHP 8.0+ compatibility.
2. Semantic HTML5 + vanilla JS / native WP hooks.
3. Styling consistent with the CSS variables in style.css.
4. Files auto-sync with the Docker container at port 8081.
```

## 5. Business reference

- **Bella's Cafe** — 137 Barrientos Street, P4 Upper Langcangan, Oroquieta City, Philippines
- Phone: +63 930 582 3469 · Dine-in · Delivery · Outdoor seating
- Facebook: https://www.facebook.com/profile.php?id=100087853257684
- Signature items: Bella's Coffee, Bella's Spicy Ramen, Signature Halo-Halo
