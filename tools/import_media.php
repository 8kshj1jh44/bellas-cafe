<?php
/**
 * Import Bella's photos from the child theme assets into the media library
 * and set the site logo. Run: eval-file /mnt/tools/import_media.php
 */

$dir = '/var/www/html/wp-content/themes/astra-child/assets/img';
$items = [
    'logo.jpg'             => "Bella's Cafe logo",
    'cafe-interior.jpg'    => "Bella's Cafe interior",
    'halo-halo-bar.jpg'    => 'Halo-Halo Bar poster',
    'cake-display.jpg'     => 'Cake display chiller',
    'cake-signature.jpg'   => 'Signature cake',
    'cake-chocolate.jpg'   => 'Chocolate cake',
    'cake-almond.jpg'      => 'Almond-topped cake',
    'cake-caramel.jpg'     => 'Caramel cake',
    'cake-fudge-slice.jpg' => 'Moist chocolate fudge slice',
    'drink-frappe.jpg'     => "Bella's frappe",
    'food-trays.jpg'       => 'Food trays for sharing',
    'treats-chocolate.jpg' => 'Chocolate treats',
];

$ids = [];
foreach ( $items as $file => $title ) {
    $path = "$dir/$file";
    if ( ! file_exists( $path ) ) {
        WP_CLI::warning( "missing: $file" );
        continue;
    }
    $existing = get_posts( [
        'post_type'   => 'attachment',
        'title'       => $title,
        'numberposts' => 1,
        'fields'      => 'ids',
    ] );
    if ( $existing ) {
        $ids[ $file ] = (int) $existing[0];
        WP_CLI::log( "exists: $file -> {$existing[0]}" );
        continue;
    }
    // Copy to a temp path first: media_handle_sideload() MOVES the source file,
    // and these files live in the synced theme folder.
    $tmp = tempnam( sys_get_temp_dir(), 'bellas' ) . '-' . $file;
    copy( $path, $tmp );
    $att_id = media_handle_sideload( [ 'name' => $file, 'tmp_name' => $tmp ], 0, $title );
    if ( is_wp_error( $att_id ) ) {
        WP_CLI::warning( "failed $file: " . $att_id->get_error_message() );
        continue;
    }
    $ids[ $file ] = (int) $att_id;
    WP_CLI::log( "imported: $file -> $att_id" );
}

if ( isset( $ids['logo.jpg'] ) ) {
    set_theme_mod( 'custom_logo', $ids['logo.jpg'] );
    WP_CLI::success( 'custom_logo set to ' . $ids['logo.jpg'] );
}

WP_CLI::success( 'IDS: ' . json_encode( $ids ) );
