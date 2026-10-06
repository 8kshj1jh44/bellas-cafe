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
docker compose up -d

# 2. Fetch the Astra parent theme (it is gitignored, so clone fresh needs it once)
curl -L -o /tmp/astra.zip https://downloads.wordpress.org/theme/astra.latest.zip
unzip /tmp/astra.zip -d themes/

# 3. Open http://localhost:8081, run the WP installer,
#    then activate "Astra Child" under Appearance → Themes.
# 4. Install Elementor (Plugins → Add New) for page building.
```

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

The full cafe menu (coffee, non-coffee & frappes, rice meals, brunch, pasta & pizza, burgers, wings, halo-halo, pastries) is rendered by a shortcode in the child theme:

```text
[cafe_menu]
```

Drop it into any page with an Elementor **Shortcode** widget (or a Shortcode block). It renders tabbed category navigation with item cards, badges (`Recommended`, `Popular`, `Signature`, …), and peso pricing. To update the menu, edit the `$menu_data` array in `themes/astra-child/functions.php` — no page rebuild needed.

## Conventions

- PHP 8.0+ strict compatibility (no undefined constants in ternaries/coalescing).
- Semantic HTML5 + vanilla JS / native WordPress hooks — no page-builder lock-in for dynamic markup.
- Styling goes through the CSS variables above so Elementor sections and theme code stay consistent.
