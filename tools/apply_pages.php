<?php
/**
 * Convert the About + Contact pages to the child-theme shortcodes and set the
 * footer copyright. Run via the wp-cli sidecar (see AGENTS.md recipe):
 *   eval-file /mnt/tools/apply_pages.php
 */

// --- Contact page: drop Elementor rendering, use [cafe_contact] ---
$contact_id = 11;
foreach ( [
    '_elementor_data',
    '_elementor_edit_mode',
    '_elementor_template_type',
    '_elementor_version',
    '_elementor_migrations_state_d2a1',
    '_elementor_page_assets',
    '_elementor_css',
    '_elementor_element_cache',
] as $meta_key ) {
    delete_post_meta( $contact_id, $meta_key );
}

wp_update_post(
    [
        'ID'           => $contact_id,
        'post_content' => "<!-- wp:shortcode -->[cafe_contact]<!-- /wp:shortcode -->",
    ],
    true
);
if ( is_wp_error( $contact_result = get_post( $contact_id ) ) ) {
    WP_CLI::error( 'Contact update failed' );
}

// --- About page: use [cafe_story] ---
wp_update_post(
    [
        'ID'           => 10,
        'post_content' => "<!-- wp:shortcode -->[cafe_story]<!-- /wp:shortcode -->",
    ],
    true
);

// --- Footer copyright (Astra footer builder text) ---
set_theme_mod( 'footer-copyright-editor', '[copyright] [current_year] [site_title] · 137 Barrientos St., Oroquieta City · Dine-in · Delivery · Outdoor seating' );

WP_CLI::success( 'Pages converted and footer copyright set.' );
