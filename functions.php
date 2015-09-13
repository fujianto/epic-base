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
 * @package    EpicBase
 * @subpackage Functions
 * @version    0.0.1
 * @author     Septian Ahmad Fujianto <septianahmad@naisinpo.com>
 * @copyright  Copyright (c) 2013 - 2015, Septian Ahmad Fujianto
 * @link       http://seotemplates.net/themes/epic-base
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Define constant for easy access to Theme directory*/
define( 'HOME_URI'      , home_url()                   );
define( 'THEME_URI'     , get_template_directory_uri() );
define( 'THEME_DIR'     , get_template_directory() 	   );
define( 'THEME_IMAGES'  , THEME_URI . '/images'        );
define( 'THEME_CSS'     , THEME_URI . '/css'           );
define( 'THEME_JS'      , THEME_URI . '/js'            );
define( 'THEME_FONTS'   , THEME_URI . '/fonts'         );
define( 'THEME_VENDOR'  , THEME_URI . '/vendor'        );

/* Set Hybrid Core to Composer custom directory */
define( 'HYBRID_DIR'    , THEME_DIR . '/vendor/composer/justintadlock/hybrid-core/');
define( 'HYBRID_URI'    , THEME_URI . '/vendor/composer/justintadlock/hybrid-core/');

/* Get the template directory and make sure it has a trailing slash. */
$epic_base_dir = trailingslashit( get_template_directory() );

/* Load composer dependencies */
require 'vendor/composer/autoload.php';

/* Load the Hybrid Core framework and theme files. */
require_once( $epic_base_dir . 'inc/theme.php'            );
require_once( $epic_base_dir . 'vendor/caviar/caviar.php' );
require_once( $epic_base_dir . 'vendor/caviar/field-example-metaboxes.php' );

new Caviar();

new Hybrid();

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
			'1c'        => __( '1 Column',                     'epic-base' ),
			'2c-l'      => __( '2 Columns: Content / Sidebar', 'epic-base' ),
			'2c-r'      => __( '2 Columns: Sidebar / Content', 'epic-base' )
			),
		array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) 
		);

	/* Theme Support for Caviar Libarary */
	add_theme_support( 'caviar-basic-fields' );
	add_theme_support( 'caviar-field-controls');

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