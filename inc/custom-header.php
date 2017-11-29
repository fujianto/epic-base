<?php

/* Call late so child themes can override. */
add_action( 'after_setup_theme', 'epic_base_custom_header_setup', 15 );

/**
 * Adds support for the WordPress 'custom-header' theme feature and registers custom headers.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function epic_base_custom_header_setup() {

	/* Adds support for WordPress' "custom-header" feature. */
	add_theme_support(
		'custom-header',
		array(
			'default-image'          => esc_url( EPIC_BASE_IMAGES . '/header.jpg' ),
			'random-default'         => false,
			'width'                  => absint( 1280 ),
			'height'                 => absint( 400 ),
			'flex-width'             => true,
			'flex-height'            => true,
			'default-text-color'     => sanitize_hex_color_no_hash( '000000' ),
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => 'epic_base_custom_header_wp_head',
		)
	);

	/*
	 Registers default headers for the theme. */
	// register_default_headers();
}

/**
 * Callback function for outputting the custom header CSS to `wp_head`.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function epic_base_custom_header_wp_head() {

	if ( ! display_header_text() ) {
		return;
	}

	$hex =  sanitize_hex_color_no_hash(get_header_textcolor());

	if ( ! $hex ) {
		return;
	}

	$style = "body.custom-header #site-title a { color: #{$hex}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}
