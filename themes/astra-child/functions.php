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
}

// Add your custom hooks, filters, and functions below:

// Example 1: Add a custom message right after the header using an Astra hook
add_action( 'astra_header_after', 'my_custom_banner' );
function my_custom_banner() {
    echo '<div class="custom-alert">Welcome to our new site!</div>';
}

// Example 2: Change read-more excerpt text length
add_filter( 'excerpt_length', function( $length ) {
    return 20;
}, 999 );

/**
 * Bella's Cafe Menu Shortcode
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
                ['name' => 'Vanilla / Hazelnut / Toffee Nut Latte', 'price' => '₱125.00'],
                ['name' => 'Spanish Latte', 'price' => '₱125.00', 'badge' => 'Recommended'],
                ['name' => 'Caramel Macchiato', 'price' => '₱125.00', 'badge' => 'Recommended'],
            ],
            'Iced Coffee' => [
                ['name' => 'Iced Americano', 'price' => '₱110.00'],
                ['name' => 'Iced Cafe Latte', 'price' => '₱140.00'],
                ['name' => 'Iced Dark Mocha / White Mocha', 'price' => '₱145.00', 'badge' => 'Popular'],
                ['name' => 'Iced Caramel Macchiato', 'price' => '₱150.00'],
                ['name' => 'Iced Spanish Latte', 'price' => '₱145.00', 'badge' => 'Popular'],
                ['name' => 'Matcha Espresso', 'price' => '₱160.00', 'badge' => 'Favorite'],
            ],
            'Non-Coffee & Frappes' => [
                ['name' => 'Matcha Latte', 'price' => '₱140.00', 'badge' => 'Popular'],
                ['name' => 'Java Chips Frappe', 'price' => '₱170.00'],
                ['name' => 'Matcha Green Tea Frappe', 'price' => '₱170.00'],
                ['name' => 'Mango / Strawberry Smoothie', 'price' => '₱160.00'],
                ['name' => 'Cookies & Cream Frappe', 'price' => '₱160.00'],
            ],
            'Signature Drinks' => [
                ['name' => "Bella's Coffee", 'price' => '₱150.00', 'badge' => 'Signature'],
                ['name' => 'Barista / Barista 2.0', 'price' => '₱150.00'],
                ['name' => 'Calamansi Elderflower Iced Tea', 'price' => '₱120.00', 'badge' => 'Refreshing'],
                ['name' => 'Mango Guava Lemon Splash', 'price' => '₱120.00', 'badge' => 'Refreshing'],
            ],
        ],
        'Mains & Rice Bowls' => [
            'Rice Meals' => [
                ['name' => 'Beef Rice Bowl', 'price' => '₱265.00', 'desc' => 'Thinly sliced beef, tender onions simmered over savory sweet sauce, kimchi & boiled egg.'],
                ['name' => 'Sticky Pork with Fried Rice', 'price' => '₱245.00', 'desc' => 'Sticky pork on fried rice packed with egg, veggies, and secret savory sauce.'],
                ['name' => 'Schnitzel Pork (Cutlet)', 'price' => '₱265.00', 'desc' => 'Delightfully crunchy pork cutlet with rice, greens, and signature mushroom sauce.'],
                ['name' => 'Pork Humba Meal', 'price' => '₱245.00', 'desc' => 'Special humba served with green salad and dessert.', 'badge' => 'Favorite'],
                ['name' => 'Orange Chicken Meal', 'price' => '₱245.00', 'desc' => 'Coated chicken breast tossed in sweet & savory orange sauce.'],
                ['name' => 'Crunchy Prawns', 'price' => '₱325.00', 'desc' => 'Golden, crispy, and delicately flavored prawns served with rice.', 'badge' => 'Must Try'],
            ],
            'All-Day Brunch' => [
                ['name' => 'Boneless Bangus', 'price' => '₱265.00', 'desc' => 'Served with rice, egg & veggies.', 'badge' => 'Favorite'],
                ['name' => 'Beef Tapa', 'price' => '₱285.00', 'desc' => 'Classic cured beef served with rice, egg & veggies.'],
                ['name' => 'Spam Brunch', 'price' => '₱265.00', 'desc' => 'Served with rice, egg & fruit.'],
            ],
            'Pasta & Pizza' => [
                ['name' => 'Meatball Truffle Pizza', 'price' => '₱365.00'],
                ['name' => 'Garlic Shrimp Spaghetti', 'price' => '₱225.00', 'badge' => 'Favorite'],
                ['name' => 'Creamy Beef Lasagna', 'price' => '₱225.00', 'badge' => 'Favorite'],
                ['name' => 'Spaghetti Bolognese', 'price' => '₱235.00'],
            ],
        ],
        'Burgers & Snacks' => [
            'Gourmet Burgers' => [
                ['name' => 'Chori Burger', 'price' => '₱150.00', 'desc' => 'Chorizo patty, coleslaw, cheese, and signature sauce in brioche.'],
                ['name' => 'Spicy Chicken Burger', 'price' => '₱165.00', 'desc' => 'Chicken patty, egg, greens, caramelized onions, spicy sauce.'],
                ['name' => 'Shrimp Katsu Burger', 'price' => '₱175.00', 'desc' => 'Crispy shrimp katsu, sliced cabbage, tartar sauce.'],
                ['name' => 'Beef Burger', 'price' => '₱185.00', 'desc' => 'Beef patty, greens, caramelized tomato, mushrooms & potato chips in brioche.', 'badge' => 'Favorite'],
                ['name' => 'Burger Sliders (Trio)', 'price' => '₱200.00', 'desc' => 'Combination of 3 mini burgers: katsu, chicken, and beef/chori.'],
            ],
            'Appetizers & Wings' => [
                ['name' => 'Sweet & Savory Wings (Platter)', 'price' => '₱299.00 / ₱425.00'],
                ['name' => 'Salted Egg & Milk Wings', 'price' => '₱299.00'],
                ['name' => 'Kamote Fries / Chips', 'price' => '₱95.00', 'badge' => 'Cafe Classic'],
                ['name' => 'Beef Nachos', 'price' => '₱200.00'],
                ['name' => "Bella's Spicy Ramen", 'price' => '₱225.00', 'badge' => 'Signature'],
            ],
        ],
        'Desserts & Halo-Halo' => [
            "Bella's Signature Halo-Halo" => [
                ['name' => 'Classic Halo-Halo', 'price' => '₱125.00', 'badge' => 'Most Ordered'],
                ['name' => 'Ube Halo-Halo', 'price' => '₱148.00'],
                ['name' => 'Mango Caramel Halo-Halo', 'price' => '₱158.00', 'badge' => 'Favorite'],
                ['name' => 'Buko Pandan Halo-Halo', 'price' => '₱148.00'],
                ['name' => 'Mais Con Yelo', 'price' => '₱110.00'],
            ],
            'Pastries & Cakes' => [
                ['name' => 'Frozen Mango Torte', 'price' => '₱160.00'],
                ['name' => 'Tiramisu Slice', 'price' => '₱195.00', 'badge' => 'Favorite'],
                ['name' => 'Moist Chocolate Fudge', 'price' => '₱160.00'],
                ['name' => 'Savory Torta / Brownies', 'price' => '₱60.00 / ₱85.00'],
                ['name' => 'Cassava Slice', 'price' => '₱45.00', 'badge' => 'Most Ordered'],
            ],
        ],
    ];

    ob_start();
    ?>
    <div class="bellas-menu-container">
        <div class="bellas-menu-nav">
            <?php $i = 0; foreach ($menu_data as $tab => $subcategories): ?>
                <button class="bellas-tab-btn <?php echo $i === 0 ? 'active' : ''; ?>" onclick="openMenuTab(event, '<?php echo sanitize_title($tab); ?>')">
                    <?php echo esc_html($tab); ?>
                </button>
            <?php $i++; endforeach; ?>
        </div>

        <?php $i = 0; foreach ($menu_data as $tab => $subcategories): ?>
            <div id="<?php echo sanitize_title($tab); ?>" class="bellas-tab-content" style="<?php echo $i === 0 ? 'display:block;' : 'display:none;'; ?>">
                <div class="bellas-subcats-grid">
                    <?php foreach ($subcategories as $subcat_title => $items): ?>
                        <div class="bellas-menu-card">
                            <h3 class="bellas-subcat-title"><?php echo esc_html($subcat_title); ?></h3>
                            <ul class="bellas-item-list">
                                <?php foreach ($items as $item): ?>
                                    <li class="bellas-item">
                                        <div class="bellas-item-main">
                                            <span class="bellas-item-name">
                                                <?php echo esc_html($item['name']); ?>
                                                <?php if (!empty($item['badge'])): ?>
                                                    <span class="bellas-badge"><?php echo esc_html($item['badge']); ?></span>
                                                <?php endif; ?>
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
        <?php $i++; endforeach; ?>
    </div>

    <script>
    function openMenuTab(evt, tabName) {
        var contents = document.getElementsByClassName("bellas-tab-content");
        for (var i = 0; i < contents.length; i++) {
            contents[i].style.display = "none";
        }
        var buttons = document.getElementsByClassName("bellas-tab-btn");
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.classList.add("active");
    }
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('cafe_menu', 'bellas_render_menu_shortcode');