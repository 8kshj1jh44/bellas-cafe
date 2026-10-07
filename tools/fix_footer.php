<?php
$settings = function_exists( 'astra_get_raw_options' ) ? astra_get_raw_options( array() ) : get_option( 'astra-settings', array() );
if ( ! is_array( $settings ) ) {
    $settings = (array) $settings;
}
$settings['footer-copyright-editor'] = '[copyright] [current_year] [site_title] · 137 Barrientos St., Oroquieta City · Dine-in · Delivery · Outdoor seating';
update_option( 'astra-settings', $settings, false );
delete_option( 'astra-settings-cache' );
WP_CLI::success( 'option astra-settings updated' );
