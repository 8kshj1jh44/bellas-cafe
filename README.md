# Bella's Cafe — Website

> *"Where every visit feels like home — cozy vibes, heartfelt food, and sweet moments served daily."*

Public website for **Bella's Cafe**, a cozy cafe in Oroquieta City, Philippines, serving coffee, rice bowls, gourmet burgers, and signature halo-halo.

- 📘 Facebook: [Bella's Cafe](https://www.facebook.com/profile.php?id=100087853257684)
- 📍 137 Barrientos Street, P4 Upper Langcangan, Oroquieta City, Philippines
- 📞 +63 930 582 3469
- ☕ Dine-in · Delivery · Outdoor seating

---

## Stack

| Layer      | Choice                                        |
|------------|-----------------------------------------------|
| CMS        | WordPress (Docker Compose, PHP 8.0+)          |
| Theme      | [Astra](https://wpastra.com/) (parent, untracked) |
| Child      | `themes/astra-child` — all custom code lives here |
| Builder    | Elementor (pages composed visually, theme code powers dynamic pieces) |
| Local URL  | http://localhost:8081                         |

## Repository layout

```text
.
├── docker-compose.yml      # WordPress + MySQL 8.0 stack (port 8081)
├── themes/
│   ├── astra/              # Parent theme — NOT committed (see setup)
│   └── astra-child/        # ✅ Custom child theme (tracked)
│       ├── style.css       # Design tokens + menu styling
│       └── functions.php   # Enqueues, hooks, [cafe_menu] shortcode
└── AGENTS.md               # Notes for coding agents working on this repo
```

## Quick start

```bash
# 1. Boot the stack
#    NOTE: on this machine the stack was first created under the compose
#    project name "testwebsite" (before the folder was renamed). Reuse it to
#    keep the existing database volumes:
docker compose -p testwebsite up -d
#    On a fresh clone, plain `docker compose up -d` is fine.

# 2. Fetch the Astra parent theme (it is gitignored, so clone fresh needs it once)
curl -L -o /tmp/astra.zip https://downloads.wordpress.org/theme/astra.latest.zip
unzip /tmp/astra.zip -d themes/

# 3. Open http://localhost:8081, run the WP installer,
#    then activate "Astra Child" under Appearance → Themes.

# 4. Install Elementor (Plugins → Add New) for page building.

# 5. Optional: scaffold the starter pages (Home, Menu, About, Contact) and
#    set the front page — idempotent, safe to re-run. Add BELLAS_SCAFFOLD_MODE=update
#    to also refresh the Elementor layouts of existing pages (and flush Elementor's
#    element/CSS caches, which do NOT invalidate on raw meta writes):
docker run --rm --user 33:33 --network container:wordpress_site2 \
  -v testwebsite_wordpress_site2_data:/var/www/html \
  -v "$(pwd)/tools:/mnt/tools:ro" \
  -e BELLAS_SCAFFOLD_MODE=update \
  -e WORDPRESS_DB_HOST=db:3306 -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress_password -e WORDPRESS_DB_NAME=wordpress_site2 \
  wordpress:cli eval-file /mnt/tools/scaffold-pages.php
```

> The `--user 33:33` matters: the `wordpress:cli` image is Alpine-based where
> `www-data` is uid 82, but the site volume is owned by uid 33 (Debian's
> `www-data`), so running as the default user cannot write files.
> (On Windows Git Bash, prefix the command with `MSYS_NO_PATHCONV=1`.)

## Design tokens

Defined as CSS variables in `themes/astra-child/style.css`:

| Variable         | Value     | Use                  |
|------------------|-----------|----------------------|
| `--bella-green`  | `#3d5a2b` | Primary / accents    |
| `--bella-gold`   | `#e2a02b` | Highlights / badges  |
| `--bella-cream`  | `#faf7f2` | Background           |
| `--bella-text`   | `#2f2a24` | Body text            |
| `--bella-border` | `#e9e3d8` | Cards / dividers     |

## Menu system

The full cafe menu is rendered by a shortcode in the child theme (source of truth: the official **"Updated Menu_2026 22w"** menu boards from the Bella's Facebook page):

```text
[cafe_menu]
```

Drop it into any page with an Elementor **Shortcode** widget (or a Shortcode block). It renders five tabs — **Drinks, Rice Meals & Brunch, Pizza/Pasta & Burgers, Snacks & Sides, Halo-Halo & Desserts** — with item cards, badge chips (`Recommended`, `Favorite`, `Signature Recipe`, `Cafe Classic`, `New to Try`, `For Sharing`, …), descriptions, and peso pricing. To update the menu, edit the `$menu_data` array in `themes/astra-child/functions.php` — no page rebuild needed. Items accept either a single `badge` or a `badges` array.

## Conventions

- PHP 8.0+ strict compatibility (no undefined constants in ternaries/coalescing).
- Semantic HTML5 + vanilla JS / native WordPress hooks — no page-builder lock-in for dynamic markup.
- Styling goes through the CSS variables above so Elementor sections and theme code stay consistent.
