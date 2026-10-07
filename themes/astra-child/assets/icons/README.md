# Bella's Cafe icon set

Icons downloaded from [SVG Repo](https://www.svgrepo.com/) and sanitized for
inline use: fixed sizes and fill colors stripped, `fill="currentColor"` applied
so CSS (`.bellas-icon` rules in the child theme `style.css`) controls size and
color. Files are safe for direct `echo` into markup (no scripts, no external
references, no event handlers).

Regenerate/extend the set with `tools/prepare_icons.py` + `tools/icon_sources.json`.

## Licensing

Most icons come from SVG Repo collections published under CC0 / public domain
(the "Food And Drink Icooon Mono" set in the `481xxx`–`482xxx` range was
verified CC0 on its collection page). For the remainder, the icon page linked
below states the license — SVG Repo shows it under each icon. Before
redistributing this set as an icon library, re-verify each linked page.
(Inline use on the site with this attribution file retained is the intended use.)

## Icons

| File | Used for | Source |
| --- | --- | --- |
| `coffee-cup.svg` | Drinks tab, Hot Coffee | [Coffee Cup With Steam](https://www.svgrepo.com/svg/102979/coffee-cup-with-steam) |
| `coffee-to-go.svg` | Signature Coffee | [Coffee To Go](https://www.svgrepo.com/svg/476855/coffee-to-go) |
| `iced-coffee.svg` | Iced Coffee | [Iced Coffee Cold Drink](https://www.svgrepo.com/svg/201483/iced-coffee-cold-drink) |
| `milkshake.svg` | Non-Coffee & Frappes | [Milkshake Cup](https://www.svgrepo.com/svg/184489/milkshake-cup) |
| `hot-chocolate.svg` | Milo Series | [Hot Chocolate Cup](https://www.svgrepo.com/svg/146878/hot-chocolate-cup) |
| `soft-drink.svg` | Others | [Can Juice 2](https://www.svgrepo.com/svg/482021/can-juice-2) |
| `tea.svg` | Tea-Based | [Tea](https://www.svgrepo.com/svg/482022/tea) |
| `meal.svg` | Rice Meals & Brunch tab, Meals Menu | [Meal](https://www.svgrepo.com/svg/482032/meal) |
| `egg.svg` | Brunch | [Egg](https://www.svgrepo.com/svg/482001/egg) |
| `pizza.svg` | Pizza, Pasta & Burgers tab, Pizza | [Pizza](https://www.svgrepo.com/svg/482148/pizza) |
| `spaghetti.svg` | Pasta | [Spaghetti](https://www.svgrepo.com/svg/482342/spaghetti) |
| `hamburger.svg` | Gourmet Burgers | [Hamburger 5](https://www.svgrepo.com/svg/482029/hamburger-5) |
| `sandwich.svg` | Sandwiches | [Sandwich](https://www.svgrepo.com/svg/151515/sandwich) |
| `fried-chicken.svg` | Chicken Wings | [Chicken Leg](https://www.svgrepo.com/svg/1454/chicken-leg) |
| `french-fries.svg` | Snacks & Sides tab, Appetizers | [French Fries 1](https://www.svgrepo.com/svg/482197/french-fries-1) |
| `vegetable-basket.svg` | Healthy Salad | [Vegetables Basket](https://www.svgrepo.com/svg/124827/vegetables-basket) |
| `smoothie.svg` | Bella's Signature Halo-Halo | [Smoothie](https://www.svgrepo.com/svg/522453/smoothie) |
| `ice-cream.svg` | Halo-Halo & Desserts tab, Desserts | [Ice Cream](https://www.svgrepo.com/svg/108284/ice-cream) |
| `tiramisu.svg` | Cake Slice | [Tiramisu Cake 2](https://www.svgrepo.com/svg/482007/tiramisu-cake-2) |
| `donut.svg` | Pastries | [Donut 2](https://www.svgrepo.com/svg/482028/donut-2) |
| `popcorn.svg` | Treats | [Popcorn](https://www.svgrepo.com/svg/482030/popcorn) |
| `fork-knife.svg` | Fallback (any category without a mapped icon) | [Fork And Knife Combination Part 2](https://www.svgrepo.com/svg/481995/fork-and-knife-combination-part-2) |
| `sofa.svg` | Dine-in (available for homepage features) | [Sofa](https://www.svgrepo.com/svg/109821/sofa) |
| `delivery.svg` | Delivery (available for homepage features) | [Delivery Truck](https://www.svgrepo.com/svg/103456/delivery-truck) |
| `umbrella.svg` | Outdoor seating (available for homepage features) | [Sun Umbrella](https://www.svgrepo.com/svg/106026/sun-umbrella) |
| `map-pin.svg` | Address (available for Find Us / contact) | [Map Pin](https://www.svgrepo.com/svg/1276/map-pin) |
| `phone.svg` | Phone (available for contact) | [Phone Call](https://www.svgrepo.com/svg/101073/phone-call) |
| `clock.svg` | Hours (available for contact) | [Clock](https://www.svgrepo.com/svg/101623/clock) |
| `facebook.svg` | Facebook (available for social links) | [Facebook](https://www.svgrepo.com/svg/10336/facebook) |

## Usage

- PHP: `echo bellas_icon( 'pizza' );` (in the child theme)
- Anywhere shortcodes work, incl. Elementor Shortcode/HTML widgets:
  `[bellas_icon name="pizza"]`
- Color/size via CSS: icons inherit `currentColor`; see `.bellas-icon` rules in
  the child theme `style.css`.
