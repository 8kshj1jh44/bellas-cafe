<?php
/**
 * Astra Child Theme functions and definitions
 */

add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles' );
function astra_child_enqueue_styles() {
    wp_enqueue_style(
        'astra-child-theme-css',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'astra-theme-css' ),
        wp_get_theme()->get( 'Version' )
    );

    // Menu tabs: instant switching (links + ?menu_tab= work without it).
    wp_enqueue_script(
        'bellas-menu-tabs',
        get_theme_file_uri( 'assets/js/menu.js' ),
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );
}

// Add your custom hooks, filters, and functions below:

/**
 * Bella's icon library.
 * Icons are sanitized SVGs downloaded from svgrepo.com (CC0-licensed set),
 * stored in assets/icons/ and rendered inline so they inherit color via
 * currentColor. Usage: bellas_icon( 'coffee-cup' ) or [bellas_icon name="coffee-cup"].
 */
function bellas_icon( $name ) {
    static $cache = [];
    $name = sanitize_key( str_replace( '_', '-', (string) $name ) );
    if ( '' === $name ) {
        return '';
    }
    if ( ! isset( $cache[ $name ] ) ) {
        $raw = file_get_contents( get_theme_file_path( "assets/icons/{$name}.svg" ) );
        if ( false === $raw ) {
            $cache[ $name ] = '';
        } else {
            $svg = preg_replace( '/<\?xml[^>]*\?>/i', '', $raw );
            $svg = preg_replace( '/<!DOCTYPE[^>]*>/si', '', $svg );
            $svg = preg_replace( '/<!--.*?-->/s', '', $svg );
            $svg = preg_replace( '/<svg\b/i', '<svg class="bellas-icon bellas-icon-' . $name . '" aria-hidden="true" focusable="false" role="img"', $svg, 1 );
            $cache[ $name ] = $svg;
        }
    }
    return $cache[ $name ];
}
add_shortcode( 'bellas_icon', function ( $atts ) {
    $atts = shortcode_atts( [ 'name' => '' ], $atts, 'bellas_icon' );
    return bellas_icon( $atts['name'] );
} );

/**
 * Bella's Cafe section shortcodes.
 * Content lives here (data-driven, like $menu_data) so pages stay editable
 * via simple [shortcode] blocks.
 */

function bellas_features_data() {
    return [
        [ 'icon' => 'sofa', 'title' => 'Dine-in', 'text' => 'Settle into a cozy corner — stay as long as you like.' ],
        [ 'icon' => 'delivery', 'title' => 'Delivery', 'text' => "Bella's favorites brought straight to your door." ],
        [ 'icon' => 'umbrella', 'title' => 'Outdoor seating', 'text' => 'Fresh air, warm drinks, easy conversations.' ],
    ];
}

function bellas_contact_data() {
    return [
        [
            'icon' => 'map-pin',
            'title' => 'Visit us',
            'lines' => [ '137 Barrientos Street', 'P4 Upper Langcangan', 'Oroquieta City, Philippines' ],
        ],
        [
            'icon' => 'phone',
            'title' => 'Call or order',
            'lines' => [ '<a href="tel:+639305823469">+63 930 582 3469</a>' ],
        ],
        [
            'icon' => 'clock',
            'title' => 'Hours',
            'lines' => [ 'Open daily', "Confirm today's hours on our Facebook page." ],
        ],
        [
            'icon' => 'facebook',
            'title' => 'Facebook',
            'lines' => [ '<a href="https://www.facebook.com/profile.php?id=100087853257684" target="_blank" rel="noopener">Bella&#8217;s Cafe on Facebook</a>' ],
        ],
    ];
}

function bellas_render_contact_cards() {
    ob_start();
    ?>
    <div class="bellas-contact-cards">
        <?php foreach ( bellas_contact_data() as $card ) : ?>
            <div class="bellas-contact-card">
                <span class="bellas-contact-icon"><?php echo bellas_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- sanitized SVG library ?></span>
                <h3 class="bellas-contact-title"><?php echo esc_html( $card['title'] ); ?></h3>
                <div class="bellas-contact-lines">
                    <?php foreach ( $card['lines'] as $line ) : ?>
                        <p><?php echo wp_kses_post( $line ); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <p class="bellas-contact-cta">
        <a class="bellas-button" href="tel:+639305823469"><?php echo bellas_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?> Call to order</a>
    </p>
    <?php
    return ob_get_clean();
}
add_shortcode( 'cafe_contact', 'bellas_render_contact_cards' );

function bellas_gallery_data() {
    return [
        [
            'file'    => 'cafe-interior.jpg',
            'alt'     => "Inside Bella's Cafe — cozy chairs and shelves",
            'caption' => 'Settle in — the cozy side of Barrientos Street.',
        ],
        [
            'file'    => 'drink-frappe.jpg',
            'alt'     => "Bella's branded frappe cup",
            'caption' => "Bella's frappes, made to order.",
        ],
        [
            'file'    => 'cake-signature.jpg',
            'alt'     => 'Signature cake with chocolate decoration',
            'caption' => 'Cakes from our own chiller.',
        ],
        [
            'file'    => 'treats-chocolate.jpg',
            'alt'     => "Chocolate-topped pastries with Bella's branding",
            'caption' => 'Fresh treats, baked in small batches.',
        ],
    ];
}

function bellas_render_story() {
    ob_start();
    ?>
    <div class="bellas-story">
        <div class="bellas-story-hero">
            <h2>Cozy vibes, heartfelt food, sweet moments</h2>
            <p>Bella&#8217;s Cafe is where every visit feels like home — a warm little corner of Oroquieta City
            built around good coffee, comfort food, and the people we share it with.</p>
        </div>

        <div class="bellas-story-columns">
            <div class="bellas-story-card">
                <h3><?php echo bellas_icon( 'coffee-cup' ); // phpcs:ignore WordPress.Security.EscapeOutput ?> Our story</h3>
                <p>Bella&#8217;s Cafe started with a simple idea: a place in Upper Langcangan where neighbors,
                students, and families can slow down with a cup of Bella&#8217;s Coffee or a bowl of our
                Spicy Ramen. Today, our Signature Halo-Halo and rice meals keep regulars coming back —
                and every plate still comes out of the kitchen with the same care as day one.</p>
            </div>
            <div class="bellas-story-card">
                <h3><?php echo bellas_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?> Visit us</h3>
                <p>You&#8217;ll find us at <strong>137 Barrientos Street, P4 Upper Langcangan,
                Oroquieta City</strong> — dine in, order delivery, or enjoy our outdoor seating.</p>
                <p>
                    <a class="bellas-button" href="/contact/">Get in touch</a>
                    <a class="bellas-button" href="/menu/">See the menu</a>
                </p>
            </div>
        </div>

        <div class="bellas-feature-grid">
            <?php foreach ( bellas_features_data() as $feature ) : ?>
                <div class="bellas-feature-card">
                    <span class="bellas-feature-icon"><?php echo bellas_icon( $feature['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                    <h3><?php echo esc_html( $feature['title'] ); ?></h3>
                    <p><?php echo esc_html( $feature['text'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h3 class="bellas-gallery-heading">A look inside Bella&#8217;s</h3>
        <div class="bellas-gallery">
            <?php foreach ( bellas_gallery_data() as $photo ) : ?>
                <figure class="bellas-gallery-item">
                    <img src="<?php echo esc_url( get_theme_file_uri( "assets/img/{$photo['file']}" ) ); ?>" alt="<?php echo esc_attr( $photo['alt'] ); ?>" loading="lazy" />
                    <figcaption><?php echo esc_html( $photo['caption'] ); ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'cafe_story', 'bellas_render_story' );

/**
 * Bella's Cafe Menu Shortcode
 * Source of truth: official "Updated Menu_2026 22w" boards (October 2026).
 * Usage: [cafe_menu]
 */
function bellas_render_menu_shortcode() {
    $menu_data = [
        'Drinks' => [
            'Hot Coffee' => [
                ['name' => 'Americano', 'price' => '₱105.00', 'badge' => 'Recommended'],
                ['name' => 'Cafe Latte', 'price' => '₱115.00'],
                ['name' => 'Cappuccino', 'price' => '₱115.00'],
                ['name' => 'Dark Mocha', 'price' => '₱125.00', 'badge' => 'Recommended'],
                ['name' => 'White Mocha', 'price' => '₱125.00'],
                ['name' => 'Vanilla Latte', 'price' => '₱125.00'],
                ['name' => 'Hazelnut Latte', 'price' => '₱125.00'],
                ['name' => 'Toffee Nut Latte', 'price' => '₱125.00'],
                ['name' => 'Spanish Latte', 'price' => '₱125.00', 'badge' => 'Recommended'],
                ['name' => 'Salted Caramel', 'price' => '₱125.00'],
                ['name' => 'Caramel Macchiato', 'price' => '₱125.00', 'badge' => 'Recommended'],
                ['name' => 'Nutty Choco', 'price' => '₱125.00'],
            ],
            'Iced Coffee' => [
                ['name' => 'Iced Americano', 'price' => '₱110.00'],
                ['name' => 'Iced Cafe Latte', 'price' => '₱140.00'],
                ['name' => 'Iced Dark Mocha', 'price' => '₱145.00', 'badge' => 'Recommended'],
                ['name' => 'Iced White Mocha', 'price' => '₱145.00'],
                ['name' => 'Iced Caramel Macchiato', 'price' => '₱150.00', 'badge' => 'Recommended'],
                ['name' => 'Iced Salted Caramel Latte', 'price' => '₱145.00', 'badge' => 'Recommended'],
                ['name' => 'Iced Spanish Latte', 'price' => '₱145.00', 'badge' => 'Recommended'],
                ['name' => 'Iced Vanilla Latte', 'price' => '₱145.00'],
                ['name' => 'Iced Hazelnut Latte', 'price' => '₱145.00'],
                ['name' => 'Iced Toffee Nut Latte', 'price' => '₱145.00'],
                ['name' => 'Matcha Espresso', 'price' => '₱150.00'],
                ['name' => 'Iced Nutty Choco', 'price' => '₱145.00'],
            ],
            'Non-Coffee & Frappes' => [
                ['name' => 'Matcha Latte', 'price' => '₱140.00', 'badge' => 'Recommended'],
                ['name' => 'Java Chips Frappe', 'price' => '₱170.00', 'badge' => 'Recommended'],
                ['name' => 'Matcha Green Tea Frappe', 'price' => '₱170.00', 'badge' => 'Recommended'],
                ['name' => 'Mango Smoothie', 'price' => '₱160.00'],
                ['name' => 'Strawberry Smoothie', 'price' => '₱160.00'],
                ['name' => 'Vanilla Ice Cream Shake', 'price' => '₱160.00'],
                ['name' => 'Vanilla White', 'price' => '₱160.00'],
                ['name' => 'Cookies & Cream Frappe', 'price' => '₱160.00', 'badge' => 'Recommended'],
                ['name' => 'Salted Caramel Frappe', 'price' => '₱160.00'],
                ['name' => 'Chocolate Frappe', 'price' => '₱160.00'],
                ['name' => 'Chocolate Strawberry Frappe', 'price' => '₱160.00'],
                ['name' => 'Chocolate Hazelnut Frappe', 'price' => '₱160.00'],
            ],
            'Tea-Based' => [
                ['name' => 'Peach Iced Tea', 'price' => '₱100.00'],
                ['name' => 'Raspberry Iced Tea', 'price' => '₱100.00', 'badge' => 'Recommended'],
                ['name' => 'Strawberry Iced Tea', 'price' => '₱100.00'],
                ['name' => 'Lemon Iced Tea', 'price' => '₱100.00'],
                ['name' => 'Calamansi Elderflower Iced Tea', 'price' => '₱120.00', 'badge' => 'Recommended'],
                ['name' => 'Mango Guava Lemon Splash', 'price' => '₱120.00'],
                ['name' => 'Peach Passion Fruit Tea', 'price' => '₱120.00'],
            ],
            'Milo Series' => [
                ['name' => 'Milo Cream Latte', 'price' => '₱135.00'],
                ['name' => 'Matcha Milo', 'price' => '₱145.00', 'badge' => 'Recommended'],
                ['name' => 'Oreo Milo', 'price' => '₱135.00'],
            ],
            'Signature Coffee' => [
                ['name' => "Bella's Coffee", 'price' => '₱150.00', 'badges' => ['Signature', 'Recommended']],
                ['name' => 'Barista', 'price' => '₱150.00'],
                ['name' => 'Barista 2.0', 'price' => '₱150.00'],
            ],
            'Others' => [
                ['name' => 'Tea Bags', 'price' => '₱65.00'],
                ['name' => 'Citron Honey Lemon Tea (Hot)', 'price' => '₱75.00'],
                ['name' => 'Citron Honey Lemon Tea (Cold)', 'price' => '₱85.00'],
                ['name' => 'Coke', 'price' => '—'],
                ['name' => 'Royal', 'price' => '—'],
                ['name' => 'Sprite', 'price' => '—'],
                ['name' => 'Mineral Water', 'price' => '₱25.00'],
            ],
        ],
        'Rice Meals & Brunch' => [
            'Meals Menu' => [
                ['name' => 'Beef Rice Bowl', 'price' => '₱265.00', 'badge' => 'Bold Flavor', 'desc' => 'Thinly sliced beef, tender onions simmered over a savory sweet sauce and served with rice, kimchi & boiled egg.'],
                ['name' => 'Sticky Pork with Fried Rice', 'price' => '₱245.00', 'badge' => 'Bold Flavor', 'desc' => 'Sticky pork on top of an epic fried rice packed with egg, veggies and our secret savory sauce.'],
                ['name' => 'Schnitzel Pork (Cutlet)', 'price' => '₱265.00', 'badge' => 'Light & Crisp', 'desc' => 'Delightfully crunchy pork cutlet served with rice, greens and our signature mushroom sauce.'],
                ['name' => 'Pork Humba Meal', 'price' => '₱245.00', 'badges' => ['Favorite', 'Signature Recipe'], 'desc' => 'Our own special version of humba served with rice, green salad and a dessert.'],
                ['name' => 'Orange Chicken Meal', 'price' => '₱245.00', 'badge' => 'Cafe Classic', 'desc' => 'Coated chicken breast tossed in a bright, sweet and savory orange sauce, served with rice.'],
                ['name' => 'Fresh Greens & Pasta', 'price' => '₱225.00', 'desc' => 'Fresh green salad with meatball pasta and dessert.'],
                ['name' => 'Pork Ribs in Curry Sauce', 'price' => '₱245.00', 'badge' => 'Curry Fresh', 'desc' => 'Slow-cooked pork ribs in Japanese curry served with rice.'],
                ['name' => 'Crunchy Prawns', 'price' => '₱325.00', 'badges' => ['Favorite', 'New to Try'], 'desc' => 'Golden, crispy, and delicately flavored prawns served with rice.'],
            ],
            'Brunch' => [
                ['name' => 'Boneless Bangus', 'price' => '₱265.00', 'badge' => 'Favorite', 'desc' => 'With rice, egg & veggies.'],
                ['name' => 'Beef Tapa', 'price' => '₱285.00', 'badge' => 'Bold Flavor', 'desc' => 'With rice, egg & veggies.'],
                ['name' => 'Spam', 'price' => '₱265.00', 'badge' => 'Comfort Any Time', 'desc' => 'With rice, egg & fruits.'],
            ],
        ],
        'Pizza, Pasta & Burgers' => [
            'Pizza' => [
                ['name' => 'Meatball Truffle', 'price' => '₱365.00'],
                ['name' => 'Hawaiian', 'price' => '₱345.00'],
                ['name' => 'All Cheese', 'price' => '₱365.00'],
                ['name' => 'Junior Pizza (Solo)', 'price' => '₱185.00'],
            ],
            'Pasta' => [
                ['name' => 'Garlic Shrimp Spaghetti', 'price' => '₱225.00', 'badge' => 'Favorite'],
                ['name' => 'Creamy Beef Lasagna', 'price' => '₱225.00', 'badge' => 'Favorite'],
                ['name' => 'Meatball Pasta', 'price' => '₱195.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Chicken Alfredo', 'price' => '₱195.00'],
                ['name' => 'Spaghetti Bolognese', 'price' => '₱235.00'],
            ],
            'Gourmet Burgers' => [
                ['name' => 'Chori Burger', 'price' => '₱150.00', 'badge' => 'Cafe Classic', 'desc' => 'Chorizo patty with coleslaw, cheese and our signature sauce in soft brioche bun.'],
                ['name' => 'Spicy Chicken Burger', 'price' => '₱165.00', 'badge' => 'Bold Flavor', 'desc' => 'Chicken patty with egg, greens, caramelized onions, signature sauce in soft brioche bun.'],
                ['name' => 'Shrimp Katsu Burger', 'price' => '₱175.00', 'badge' => 'Light & Crisp', 'desc' => 'Crispy shrimp katsu, sliced cabbage, homemade tartar sauce in soft brioche bun.'],
                ['name' => 'Beef Burger', 'price' => '₱185.00', 'badges' => ['Favorite', 'Bold Flavor'], 'desc' => 'Beef patty, greens, caramelized tomato, mushrooms, onions and potato chips in soft brioche bun.'],
                ['name' => 'Sliders (Mini Burgers)', 'price' => '₱200.00', 'badges' => ['Favorite', 'For Sharing'], 'desc' => 'Combination of 3 flavors: katsu, chicken, beef or chori.'],
            ],
            'Sandwiches' => [
                ['name' => 'Bacon and Cheese Toastie', 'price' => '₱150.00', 'badge' => 'Sweet Finish', 'desc' => 'Crispy bacon, cheese, greens, homemade sauce in soft brioche bread.'],
                ['name' => 'Tuna Melt Fold-Over Sandwich', 'price' => '₱135.00', 'badge' => 'Rich & Creamy', 'desc' => 'Creamy tuna salad, melty cheese in grilled soft brioche bread.'],
            ],
        ],
        'Snacks & Sides' => [
            'Chicken Wings' => [
                ['name' => 'Sweet & Savory Wings', 'price' => '₱299.00', 'badge' => 'For Sharing'],
                ['name' => 'Salted Egg & Milk Wings', 'price' => '₱299.00', 'badge' => 'For Sharing'],
                ['name' => 'Wings Platter', 'price' => '₱425.00', 'badge' => 'For Sharing'],
            ],
            'Noodles' => [
                ['name' => "Bella's Spicy Ramen", 'price' => '₱225.00', 'badge' => 'Signature Recipe'],
                ['name' => 'Spicy Samyang with Chicken Popcorn', 'price' => '₱195.00', 'badge' => 'Super Hot'],
            ],
            'Appetizers' => [
                ['name' => 'Kamote Fries / Kamote Chips', 'price' => '₱95.00', 'badge' => 'For Sharing'],
                ['name' => 'Beef Nachos', 'price' => '₱200.00', 'badge' => 'For Sharing'],
                ['name' => 'Chicken Popcorn', 'price' => '₱150.00', 'badge' => 'For Sharing'],
            ],
            'Healthy Salad' => [
                ['name' => "Bella's Green Salad", 'price' => '₱245.00', 'badge' => 'Always a Yes', 'desc' => 'Chicken, corn, fruits, cucumber, lettuce in toasted sesame dressing.'],
            ],
        ],
        'Halo-Halo & Desserts' => [
            "Bella's Signature Halo-Halo" => [
                ['name' => 'Classic Halo-Halo', 'price' => '₱125.00', 'badge' => 'Most Ordered'],
                ['name' => 'Ube Halo-Halo', 'price' => '₱148.00'],
                ['name' => 'Mango Caramel Halo-Halo', 'price' => '₱158.00', 'badge' => 'Favorite'],
                ['name' => 'Cheese Halo-Halo', 'price' => '₱146.00'],
                ['name' => 'Buko Pandan Halo-Halo', 'price' => '₱148.00'],
                ['name' => 'Mais Con Yelo', 'price' => '₱110.00'],
                ['name' => 'Mango Junior Halo', 'price' => '₱100.00'],
                ['name' => 'Junior Halo (Other Flavors)', 'price' => '₱95.00'],
                ['name' => 'Coffee Halo', 'price' => '₱148.00'],
            ],
            'Desserts' => [
                ['name' => 'Affogato', 'price' => '₱95.00', 'badge' => 'Always a Yes'],
                ['name' => 'Frozen Mango Torte', 'price' => '₱160.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Silvanas', 'price' => '₱95.00', 'badge' => 'Light & Crisp'],
            ],
            'Pastries' => [
                ['name' => 'Savory Torta', 'price' => '₱60.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Cassava Slice', 'price' => '₱45.00', 'badge' => 'Most Ordered'],
                ['name' => 'Brownies', 'price' => '₱85.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Banana Square', 'price' => '₱45.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Caramel Apple Pie', 'price' => '₱85.00', 'badge' => 'New to Try'],
            ],
            'Cake Slice' => [
                ['name' => 'Moist Chocolate Fudge', 'price' => '₱160.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Tiramisu', 'price' => '₱195.00', 'badge' => 'Cafe Classic'],
            ],
            'Treats' => [
                ['name' => 'Peanut Cookies', 'price' => '₱150.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Sesame Thins', 'price' => '₱65.00', 'badge' => 'New to Try'],
                ['name' => 'Butter Cookies | Tea Cookies', 'price' => '₱150.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Banana Chips', 'price' => '₱150.00', 'badge' => 'Cafe Classic'],
            ],
        ],
    ];

    // Icon names map to sanitized SVGs in assets/icons/ (svgrepo.com, CC0).
    $tab_icons = [
        'drinks'               => 'coffee-cup',
        'rice-meals-brunch'    => 'meal',
        'pizza-pasta-burgers'  => 'pizza',
        'snacks-sides'         => 'french-fries',
        'halo-halo-desserts'   => 'ice-cream',
    ];
    $subcat_icons = [
        'Hot Coffee'                  => 'coffee-cup',
        'Iced Coffee'                 => 'iced-coffee',
        'Non-Coffee & Frappes'        => 'milkshake',
        'Tea-Based'                   => 'tea',
        'Milo Series'                 => 'hot-chocolate',
        'Signature Coffee'            => 'coffee-to-go',
        'Others'                      => 'soft-drink',
        'Meals Menu'                  => 'meal',
        'Brunch'                      => 'egg',
        'Pizza'                       => 'pizza',
        'Pasta'                       => 'spaghetti',
        'Gourmet Burgers'             => 'hamburger',
        'Sandwiches'                  => 'sandwich',
        'Chicken Wings'               => 'fried-chicken',
        'Noodles'                     => 'ramen',
        'Appetizers'                  => 'french-fries',
        'Healthy Salad'               => 'vegetable-basket',
        "Bella's Signature Halo-Halo" => 'smoothie',
        'Desserts'                    => 'ice-cream',
        'Pastries'                    => 'donut',
        'Cake Slice'                  => 'tiramisu',
        'Treats'                      => 'popcorn',
    ];

    ob_start();
    ?>
    <div class="bellas-menu-container" id="bellas-menu">
        <div class="bellas-menu-nav">
            <?php
            // Tabs are real links: the active tab is decided server-side via
            // ?menu_tab=, so they work even when JavaScript is unavailable
            // (assets/js/menu.js intercepts clicks for instant switching).
            $bellas_current = isset( $_GET['menu_tab'] ) ? sanitize_title( wp_unslash( $_GET['menu_tab'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $bellas_first   = sanitize_title( array_key_first( $menu_data ) );
            $bellas_active  = '';
            foreach ( array_keys( $menu_data ) as $bellas_tab ) {
                if ( sanitize_title( $bellas_tab ) === $bellas_current ) {
                    $bellas_active = $bellas_current;
                }
            }
            $bellas_active = $bellas_active ?: $bellas_first;
            foreach ($menu_data as $tab => $subcategories):
                $tab_slug = sanitize_title($tab);
                $is_active = $tab_slug === $bellas_active;
                $tab_icon = $tab_icons[$tab_slug] ?? 'fork-knife';
                ?>
                <a href="?menu_tab=<?php echo esc_attr($tab_slug); ?>#bellas-menu" data-tab="<?php echo esc_attr($tab_slug); ?>" class="bellas-tab-btn <?php echo $is_active ? 'active' : ''; ?>">
                    <?php if ( bellas_icon( $tab_icon ) ) : ?><span class="bellas-tab-icon"><?php echo bellas_icon( $tab_icon ); // phpcs:ignore WordPress.Security.EscapeOutput -- sanitized SVG library ?></span><?php endif; ?>
                    <span class="bellas-tab-label"><?php echo esc_html($tab); ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <?php foreach ($menu_data as $tab => $subcategories): ?>
            <?php $tab_slug = sanitize_title($tab); ?>
            <div id="<?php echo esc_attr($tab_slug); ?>" class="bellas-tab-content" style="<?php echo $tab_slug === $bellas_active ? 'display:block;' : 'display:none;'; ?>">
                <div class="bellas-subcats-grid">
                    <?php foreach ($subcategories as $subcat_title => $items): ?>
                        <?php $subcat_icon = $subcat_icons[$subcat_title] ?? 'fork-knife'; ?>
                        <div class="bellas-menu-card">
                            <h3 class="bellas-subcat-title">
                                <?php if ( bellas_icon( $subcat_icon ) ) : ?><span class="bellas-subcat-icon"><?php echo bellas_icon( $subcat_icon ); // phpcs:ignore WordPress.Security.EscapeOutput -- sanitized SVG library ?></span><?php endif; ?>
                                <span class="bellas-subcat-label"><?php echo esc_html($subcat_title); ?></span>
                            </h3>
                            <ul class="bellas-item-list">
                                <?php foreach ($items as $item): ?>
                                    <li class="bellas-item">
                                        <div class="bellas-item-main">
                                            <span class="bellas-item-name">
                                                <?php echo esc_html($item['name']); ?>
                                                <?php
                                                $bellas_badges = $item['badges'] ?? ( isset( $item['badge'] ) ? [ $item['badge'] ] : [] );
                                                foreach ( $bellas_badges as $bellas_badge ) :
                                                    ?>
                                                    <span class="bellas-badge"><?php echo esc_html($bellas_badge); ?></span>
                                                <?php endforeach; ?>
                                            </span>
                                            <span class="bellas-item-dots"></span>
                                            <span class="bellas-item-price"><?php echo esc_html($item['price']); ?></span>
                                        </div>
                                        <?php if (!empty($item['desc'])): ?>
                                            <p class="bellas-item-desc"><?php echo esc_html($item['desc']); ?></p>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('cafe_menu', 'bellas_render_menu_shortcode');
