<?php
/**
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Epic Base
 * @subpackage Functions
 * @version    0.2.7
 * @author     Septian Ahmad Fujianto <septianahmad@naisinpo.com>
 * @copyright  Copyright (c) 2013 - 2016, Septian Ahmad Fujianto
 * @link       http://septianfujianto.com/themes/epic-base/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
*	REPLACE THIS WITH NEW THEME NAME
*
* 	Epic Base / Theme Name (style.css)
* 	epic_base / function prefix
* 	$epic_base / Theme Variable
* 	Epic_Base / Class Prefix
* 	epic-base / Text Domain
*/

/* Define constant for easy access to Theme directory*/
define( 'EPIC_BASE_HOME_URI'      	, esc_url(home_url())              );
define( 'EPIC_BASE_URI'     , get_template_directory_uri() 		);
define( 'EPIC_BASE_DIR'     , get_template_directory() 	   		);
define( 'EPIC_BASE_IMAGES'  , EPIC_BASE_URI . '/images'        );
define( 'EPIC_BASE_CSS'     , EPIC_BASE_URI . '/css'           );
define( 'EPIC_BASE_JS'      , EPIC_BASE_URI . '/js'            );
define( 'EPIC_BASE_FONTS'   , EPIC_BASE_URI . '/fonts'         );
define( 'EPIC_BASE_VENDOR'  , EPIC_BASE_URI . '/vendor'        );

/* Set Hybrid Core to Composer custom directory */
define( 'HYBRID_DIR'    , EPIC_BASE_DIR . '/vendor/composer/justintadlock/hybrid-core/');
define( 'HYBRID_URI'    , EPIC_BASE_URI . '/vendor/composer/justintadlock/hybrid-core/');

/* Get the template directory and make sure it has a trailing slash. */
$epic_base_dir = trailingslashit( get_template_directory() );

/* Load the Hybrid Core framework and theme files. */
require_once( $epic_base_dir . 'inc/theme.php'            );

/* Hybrid core */
require_once( $epic_base_dir . 'vendor/composer/justintadlock/hybrid-core/hybrid.php' );
new Hybrid();

/* Theme Hook Alliance */
require_once( $epic_base_dir . 'vendor/composer/zamoose/themehookalliance/tha-theme-hooks.php' );

/* Bootstrap Custom Nav Walker */
require_once( $epic_base_dir . 'vendor/wp-bootstrap-navwalker/wp_bootstrap_navwalker.php' );

/* Load all files inside inc folder */
epic_base_load_all_php( $epic_base_dir . 'inc/' );

/* Load Widget */
epic_base_load_all_php( $epic_base_dir . 'widgets/' );

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'epic_base_theme_setup', 5 );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
function epic_base_theme_setup() {

	/* Theme layouts. */
	add_theme_support( 
		'theme-layouts', 
		array(
			'1c'        => esc_html__( '1 Column',                     'epic-base' ),
			'2c-l'      => esc_html__( '2 Columns: Content / Sidebar', 'epic-base' ),
			'2c-r'      => esc_html__( '2 Columns: Sidebar / Content', 'epic-base' )
			),
		array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) 
	);

	/* Add Custom Logo Options */
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/* Add support for Yoast SEO Breadcrumbs */
	add_theme_support( 'yoast-seo-breadcrumbs' );

	/* Enable custom template hierarchy. */
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );

	/* Breadcrumbs. Yay! */
	add_theme_support( 'breadcrumb-trail' );

	/* Pagination. */
	add_theme_support( 'loop-pagination' );

	/* Nicer [gallery] shortcode implementation. */
	add_theme_support( 'cleaner-gallery' );

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Automatically add feed links to <head>. */
	add_theme_support( 'automatic-feed-links' );

	/* Post formats. */
	add_theme_support( 
		'post-formats', 
			array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/* Handle content width for embeds and images. */
	hybrid_set_content_width( 1280 );
}