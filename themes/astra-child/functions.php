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
