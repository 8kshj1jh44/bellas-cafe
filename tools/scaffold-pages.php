<?php
/**
 * Bella's Cafe — one-shot page scaffold.
 *
 * Creates the core pages (Home, Menu, About, Contact), builds the Home and
 * Contact layouts as Elementor pages using the Bella's palette, and sets the
 * site identity + front page. Safe to re-run: existing pages are skipped.
 *
 * Run inside the WordPress container (or a wordpress:cli container sharing
 * the site volume + network):
 *
 *   wp eval-file /mnt/tools/scaffold-pages.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bellas_palette = array(
	'green'  => '#3d5a2b',
	'gold'   => '#e2a02b',
	'cream'  => '#faf7f2',
	'text'   => '#2f2a24',
	'muted'  => '#5f584e',
	'border' => '#e9e3d8',
	'white'  => '#ffffff',
);

/** Elementor widget node. */
function bellas_widget( $id, $widget, $settings ) {
	return array(
		'id'         => $id,
		'elType'     => 'widget',
		'settings'   => $settings,
		'elements'   => array(),
		'widgetType' => $widget,
	);
}

/** Elementor column node. */
function bellas_column( $id, $size, $settings, $widgets ) {
	$settings['_column_size'] = $size;
	return array(
		'id'       => $id,
		'elType'   => 'column',
		'settings' => $settings,
		'elements' => $widgets,
		'isInner'  => false,
	);
}

/** Elementor section node. */
function bellas_section( $id, $settings, $columns ) {
	return array(
		'id'       => $id,
		'elType'   => 'section',
		'settings' => $settings,
		'elements' => $columns,
		'isInner'  => false,
	);
}

/** Create a page once; returns the page ID or null if it already exists. */
function bellas_upsert_page( $slug, $title, $content = '', $elementor_json = null, $template = 'default' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing instanceof WP_Post ) {
		echo "skip: page '{$slug}' already exists ({$existing->ID})\n";
		return null;
	}

	$pid = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
		)
	);

	if ( is_wp_error( $pid ) || ! $pid ) {
		echo "ERROR: could not create page '{$slug}'\n";
		return null;
	}

	if ( null !== $elementor_json ) {
		update_post_meta( $pid, '_elementor_edit_mode', 'builder' );
		update_post_meta( $pid, '_elementor_template_type', 'wp-page' );
		update_post_meta( $pid, '_elementor_version', defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.25.0' );
		update_post_meta( $pid, '_elementor_data', wp_slash( wp_json_encode( $elementor_json ) ) );
		update_post_meta( $pid, '_wp_page_template', $template );
	}

	echo "created page '{$slug}' ({$pid})\n";
	return $pid;
}

/*
 * ---------------------------------------------------------------------
 * Home (Elementor)
 * ---------------------------------------------------------------------
 */
$home = array(

	// Hero.
	bellas_section(
		'sec1001',
		array(
			'background_background' => 'classic',
			'background_color'      => $bellas_palette['cream'],
			'padding'               => array(
				'unit'     => 'px',
				'top'      => '110',
				'right'    => '40',
				'bottom'   => '110',
				'left'     => '40',
				'isLinked' => false,
			),
		),
		array(
			bellas_column(
				'col1001',
				100,
				array(),
				array(
					bellas_widget(
						'w1001',
						'heading',
						array(
							'title'       => 'Where every visit feels like home',
							'header_size' => 'h1',
							'align'       => 'center',
							'title_color' => $bellas_palette['text'],
						)
					),
					bellas_widget(
						'w1002',
						'text-editor',
						array(
							'editor'     => '<p>Cozy vibes, heartfelt food, and sweet moments served daily in Oroquieta City.</p>',
							'align'      => 'center',
							'text_color' => $bellas_palette['muted'],
						)
					),
					bellas_widget(
						'w1003',
						'button',
						array(
							'text'               => 'See Our Menu',
							'align'              => 'center',
							'background_color'   => $bellas_palette['green'],
							'button_text_color'  => $bellas_palette['white'],
							'size'               => 'md',
							'link'               => array(
								'url'        => '/menu/',
								'is_external' => '',
								'nofollow'   => '',
							),
						)
					),
				)
			),
		)
	),

	// Services row.
	bellas_section(
		'sec1002',
		array(
			'padding' => array(
				'unit'     => 'px',
				'top'      => '80',
				'right'    => '40',
				'bottom'   => '40',
				'left'     => '40',
				'isLinked' => false,
			),
		),
		array(
			bellas_column(
				'col1002',
				33,
				array(),
				array(
					bellas_widget(
						'w1004',
						'icon-box',
						array(
							'selected_icon'    => array(
								'value'   => 'fas fa-utensils',
								'library' => 'fa-solid',
							),
							'title_text'       => 'Dine-in',
							'description_text' => 'Settle into a cozy corner — stay as long as you like.',
							'title_color'      => $bellas_palette['green'],
							'primary_color'    => $bellas_palette['green'],
						)
					),
				)
			),
			bellas_column(
				'col1003',
				33,
				array(),
				array(
					bellas_widget(
						'w1005',
						'icon-box',
						array(
							'selected_icon'    => array(
								'value'   => 'fas fa-motorcycle',
								'library' => 'fa-solid',
							),
							'title_text'       => 'Delivery',
							'description_text' => "Bella's favorites brought straight to your door.",
							'title_color'      => $bellas_palette['green'],
							'primary_color'    => $bellas_palette['green'],
						)
					),
				)
			),
			bellas_column(
				'col1004',
				33,
				array(),
				array(
					bellas_widget(
						'w1006',
						'icon-box',
						array(
							'selected_icon'    => array(
								'value'   => 'fas fa-mug-hot',
								'library' => 'fa-solid',
							),
							'title_text'       => 'Outdoor seating',
							'description_text' => 'Fresh air, warm drinks, easy conversations.',
							'title_color'      => $bellas_palette['green'],
							'primary_color'    => $bellas_palette['green'],
						)
					),
				)
			),
		)
	),

	// Signature band + contact CTA.
	bellas_section(
		'sec1003',
		array(
			'background_background' => 'classic',
			'background_color'      => $bellas_palette['cream'],
			'padding'               => array(
				'unit'     => 'px',
				'top'      => '80',
				'right'    => '40',
				'bottom'   => '90',
				'left'     => '40',
				'isLinked' => false,
			),
		),
		array(
			bellas_column(
				'col1005',
				100,
				array(),
				array(
					bellas_widget(
						'w1007',
						'heading',
						array(
							'title'       => "Bella's favorites",
							'header_size' => 'h2',
							'align'       => 'center',
							'title_color' => $bellas_palette['text'],
						)
					),
					bellas_widget(
						'w1008',
						'text-editor',
						array(
							'editor'     => "<p>Bella's Coffee · Spicy Ramen · Signature Halo-Halo — the plates and pours our regulars keep coming back for.</p>",
							'align'      => 'center',
							'text_color' => $bellas_palette['muted'],
						)
					),
					bellas_widget(
						'w1009',
						'button',
						array(
							'text'              => 'Find Us',
							'align'             => 'center',
							'background_color'  => $bellas_palette['gold'],
							'button_text_color' => $bellas_palette['text'],
							'size'              => 'md',
							'link'              => array(
								'url'        => '/contact/',
								'is_external' => '',
								'nofollow'   => '',
							),
						)
					),
				)
			),
		)
	),
);

/*
 * ---------------------------------------------------------------------
 * Contact (Elementor)
 * ---------------------------------------------------------------------
 */
$contact = array(
	bellas_section(
		'sec2001',
		array(
			'padding' => array(
				'unit'     => 'px',
				'top'      => '70',
				'right'    => '40',
				'bottom'   => '90',
				'left'     => '40',
				'isLinked' => false,
			),
		),
		array(
			bellas_column(
				'col2001',
				40,
				array(),
				array(
					bellas_widget(
						'w2001',
						'icon-box',
						array(
							'selected_icon'    => array(
								'value'   => 'fas fa-location-dot',
								'library' => 'fa-solid',
							),
							'title_text'       => 'Visit us',
							'description_text' => '137 Barrientos Street, P4 Upper Langcangan, Oroquieta City, Philippines',
							'title_color'      => $bellas_palette['green'],
							'primary_color'    => $bellas_palette['green'],
						)
					),
					bellas_widget(
						'w2002',
						'icon-box',
						array(
							'selected_icon'    => array(
								'value'   => 'fas fa-phone',
								'library' => 'fa-solid',
							),
							'title_text'       => 'Call or order',
							'description_text' => '+63 930 582 3469',
							'title_color'      => $bellas_palette['green'],
							'primary_color'    => $bellas_palette['green'],
							'link'             => array(
								'url'        => 'tel:+639305823469',
								'is_external' => '',
								'nofollow'   => '',
							),
						)
					),
					bellas_widget(
						'w2003',
						'icon-box',
						array(
							'selected_icon'    => array(
								'value'   => 'fas fa-clock',
								'library' => 'fa-solid',
							),
							'title_text'       => 'Hours',
							'description_text' => 'Open daily — confirm today\'s hours on our Facebook page.',
							'title_color'      => $bellas_palette['green'],
							'primary_color'    => $bellas_palette['green'],
							'link'             => array(
								'url'        => 'https://www.facebook.com/profile.php?id=100087853257684',
								'is_external' => 'on',
								'nofollow'   => '',
							),
						)
					),
				)
			),
			bellas_column(
				'col2002',
				60,
				array(),
				array(
					bellas_widget(
						'w2004',
						'google_maps',
						array(
							'address' => '137 Barrientos Street, P4 Upper Langcangan, Oroquieta City, Philippines',
						)
					),
				)
			),
		)
	),
);

/*
 * ---------------------------------------------------------------------
 * Create pages
 * ---------------------------------------------------------------------
 */
$home_id    = bellas_upsert_page( 'home', 'Home', '', $home, 'elementor_header_footer' );
$menu_id    = bellas_upsert_page(
	'menu',
	'Menu',
	"<p>Everything is made to order — coffee, comfort food, and our signature halo-halo. Call +63 930 582 3469 for deliveries.</p>\n[cafe_menu]"
);
$about_id   = bellas_upsert_page(
	'about',
	'About',
	"<p>Bella's Cafe is where every visit feels like home — cozy vibes, heartfelt food, and sweet moments served daily in a space full of charm and warmth.</p>\n<p>Find us at 137 Barrientos Street, P4 Upper Langcangan, Oroquieta City. Dine in, order delivery, or enjoy our outdoor seating.</p>"
);
$contact_id = bellas_upsert_page( 'contact', 'Contact', '', $contact, 'elementor_header_footer' );

/*
 * ---------------------------------------------------------------------
 * Site settings
 * ---------------------------------------------------------------------
 */
update_option( 'blogname', "Bella's Cafe" );
update_option( 'blogdescription', 'Cozy cafe in Oroquieta City — coffee, comfort food & halo-halo' );

if ( $home_id ) {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	echo "front page set to Home ({$home_id})\n";
}

update_option( 'permalink_structure', '/%postname%/' );
global $wp_rewrite;
$wp_rewrite->flush_rules( true );
echo "permalinks set to /%postname%/\n";

echo "done.\n";
