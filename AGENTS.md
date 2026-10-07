# AGENTS.md — Bella's Cafe Website (WordPress / Astra Child Theme)

Working notes for coding agents (and humans) contributing to this repository.

## 1. Infrastructure & Environment

- **Stack**: Docker Compose (WordPress:latest + MySQL 8.0) — see `docker-compose.yml`
- **Local URL**: http://localhost:8081
- **Compose project name**: `testwebsite` — the stack was first created when the
  folder lived at `D:\wordpress\Test Website`. Always boot with
  `docker compose -p testwebsite up -d` from this folder so the existing data
  volumes (`testwebsite_wordpress_site2_data`, `testwebsite_db_site2_data`) are
  reused. Recreating without `-p` creates a *new empty* database.
- **Theme root**: mounted locally at `./themes` → `/var/www/html/wp-content/themes`
- **Active theme**: Astra Child (`./themes/astra-child`)
- **Parent theme**: Astra (`./themes/astra` — gitignored; fetch per README quick start)
- **Page builder**: Elementor (visual page composition; dynamic markup lives in the child theme)
- **PHP version**: 8.0+ (strict typing, no undefined constants in ternary/coalescing)

### WP-CLI one-off recipe

`wordpress:latest` has no wp-cli, so run the `wordpress:cli` image as a sidecar.
Three gotchas, all baked into this command:

```bash
MSYS_NO_PATHCONV=1 docker run --rm --user 33:33 \
  --network container:wordpress_site2 \
  -v testwebsite_wordpress_site2_data:/var/www/html \
  -v "$(pwd)/tools:/mnt/tools:ro" \
  -e WORDPRESS_DB_HOST=db:3306 -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress_password -e WORDPRESS_DB_NAME=wordpress_site2 \
  wordpress:cli <wp-command | eval-file /mnt/tools/<script>.php>
```

1. `--user 33:33` — Alpine wp-cli image's `www-data` is uid 82; the site volume is owned by uid 33.
2. DB env vars — `wp-config.php` uses `getenv_docker()`, so without them wp-cli falls back to dummy credentials.
3. `--network container:wordpress_site2` — shares the WP container's netns so the `db` hostname resolves.

## 2. Directory structure

```text
.
├── docker-compose.yml
├── themes/
│   ├── astra/           # parent (untracked)
│   └── astra-child/     # all custom code
│       ├── style.css    # design tokens, menu styling, site-wide theme (header/footer/Elementor recolor)
│       ├── functions.php
│       └── assets/
│           ├── icons/   # svgrepo.com SVGs, sanitized for inline use (see README.md there)
│           └── img/     # cafe photos (web-optimized; originals live in the repo root)
├── tools/               # icon pipeline (prepare_icons.py + icon_sources.json),
│                        # wp-cli wrapper (wp-pages.sh), page-meta backups (backups/)
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
6. Icons are inline SVGs from `assets/icons/`, rendered via `bellas_icon( $name )`
   (PHP) or `[bellas_icon name="…"]` (shortcode); they inherit `currentColor`,
   so color/size is pure CSS (`.bellas-icon` rules in style.css).
7. Page section content is data-driven shortcodes in `functions.php`:
   `[cafe_menu]`, `[cafe_story]` (About), `[cafe_contact]` (Contact), with
   `bellas_features_data()` / `bellas_contact_data()` arrays. The About and
   Contact pages contain only a Shortcode block — don't rebuild them with
   Elementor (the old Contact Elementor layout is backed up in
   `tools/backups/contact-page-11-meta.json`).
8. Astra stores all customizer settings in the `astra-settings` OPTION (not
   individual theme mods) — read/modify via `astra_get_raw_options()` +
   `update_option('astra-settings', …)` (see `tools/fix_footer.php`).

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
