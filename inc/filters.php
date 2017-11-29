<?php

/**
 * Filter to add extra class to <body> tag.
 *
 * @param  String $classes Array of available class
 * @return [type]          [description]
 */
function epic_base_body_class( $classes ) {
	/* Set default layout to fluid by adding class to body */
	$theme_name = strtolower( str_replace( ' ', '-', wp_get_theme()->get( 'Name' ) ) );
	$classes[] = 'fluid ' . $theme_name;

	return $classes;
}

/* Add extra class to body */
add_filter( 'body_class', 'epic_base_body_class' );

/**
 * Add Meta tag to head
 *
 * @return Void
 */
function epic_base_tha_head_top() {
?>
	<!-- IE Meta -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Mobile Meta -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="529">

<?php

}

add_action( 'tha_head_top', 'epic_base_tha_head_top' );

/**
 * Custom content before header
 *
 * @return [type] [description]
 */
function epic_base_tha_header_before() {
?>
	<div class="skip-link">
		<a href="#content" class="sr-only screen-reader-text"><?php esc_html_e( 'Skip to content', 'epic-base' ); ?></a>
	</div><!-- .skip-link -->
<?php
}

add_action( 'tha_header_before', 'epic_base_tha_header_before' );

/**
 * Custom content after header, showing header banner by default.
 *
 * @return [type] [description]
 */
function epic_base_tha_header_after() {
	get_template_part( 'template-parts/header-banner' );
}

add_action( 'tha_header_after', 'epic_base_tha_header_after' );

function epic_base_header_content_area() {
	get_template_part( 'template-parts/header-content' );
}

add_action( 'epic_base_header_content', 'epic_base_header_content_area' );


function epic_base_header_right_content_area() {

?>

	<aside <?php hybrid_attr( 'sidebar', 'header-right' ); ?>>

		<?php if ( is_active_sidebar( 'header-right' ) ) : // If the sidebar has widgets.                           ?>

			<?php dynamic_sidebar( 'header-right' ); // Displays the header-right sidebar.                           ?>

		<?php else : // If the sidebar has no widgets, show search form.                           ?>
			
			<?php get_search_form(); ?>
			
		<?php endif; // End widgets check.                           ?>

	</aside><!-- #sidebar-header-right -->
<?php
}

add_action( 'epic_base_header_right', 'epic_base_header_right_content_area' );

/**
 * Filter to add extra attribute to Site Title
 *
 * @param  String $attr Site title attribute
 * @return Array  Attribute of Site Title
 */
function epic_base_attr_site_title( $attr ) {
	$attr['class'] = 'site-title';

	return $attr;
}

/* Add extra class to Site title */
add_filter( 'hybrid_attr_site-title', 'epic_base_attr_site_title' );

function epic_base_attr_header( $attr ) {
	$attr['class'] = 'header';

	return $attr;
}

add_filter( 'hybrid_attr_header', 'epic_base_attr_header' );

/**
 * Add extra class on site description
 *
 * @param  array $attr [description]
 * @return array       [description]
 */
function epic_base_site_description( $attr ) {
	$attr['class'] = 'site-description';

	return $attr;
}

add_filter( 'hybrid_attr_site-description', 'epic_base_site_description' );


/**
 * Content column width based on theme layout options
 *
 * @return void print entry wrapper class
 */
function epic_base_entry_col_width_config() {
	$class = '';
	/* If one column layout choosen, .col-md-12 will be added to entry-wrapper */
	if ( '1c' === hybrid_get_theme_layout() ) {
		$class = 'col-md-12 col-sm-12';

	} elseif ( '2c-r' === hybrid_get_theme_layout() ) {
		$class = 'col-md-8 col-md-push-4';

	} elseif ( is_page_template( 'page-fullwidth.php' ) ) {
		$class = 'col-md-12 col-sm-12';

	} else {
		$class = 'col-md-8';
	}

	echo apply_filters( 'epic_base_entry_col_width_filter', $class );

}

add_action( 'epic_base_entry_col_width', 'epic_base_entry_col_width_config' );

/**
 * Add custom attribute to sidebar based on sidebar name
 *
 * @param  array  $attr    [description]
 * @param  [type] $context [description]
 * @return array         [description]
 */
function epic_base_attr_sidebar( $attr, $context ) {
	$sidebar_name = hybrid_get_sidebar_name( $context );

	if ( $sidebar_name === 'Primary' ) {
		if ( '2c-r' === hybrid_get_theme_layout() ) {
			$attr['class'] = $attr['class'] . ' col-md-4 col-md-pull-8';
		} else {
			$attr['class'] = $attr['class'] . ' col-md-4';
		}
	}

	return $attr;
}

add_filter( 'hybrid_attr_sidebar', 'epic_base_attr_sidebar',  10, 2 );

/**
 * Add extra class on footer
 *
 * @param  array $attr [description]
 * @return [type]       [description]
 */
function epic_base_attr_footer( $attr ) {
	$attr['class'] = 'footer-wrapper';

	return $attr;
}

add_action( 'hybrid_attr_footer', 'epic_base_attr_footer' );

/**
 * Add extra class to entry summary
 *
 * @param  array $attr [description]
 * @return array
 */
function epic_base_attr_entry_summary( $attr ) {
	$attr['class']    = $attr['class'] . ' clearfix';

	return $attr;
}

add_action( 'hybrid_attr_entry-summary', 'epic_base_attr_entry_summary' );


/**
 * Filter for Post <article> element attributes.
 *
 * @param  array $attr
 *
 * @return array
 */
function epic_base_attr_post( $attr ) {
	$attr['class']    = $attr['class'] . ' clearfix';

	return $attr;
}

add_action( 'hybrid_attr_post', 'epic_base_attr_post' );

/**
 * Content for the copyright area in footer
 *
 * @return [type] [description]
 */
function epic_base_tha_footer_bottom() {
	get_template_part( 'template-parts/copyright-wrapper' );
}

add_action( 'tha_footer_bottom', 'epic_base_tha_footer_bottom' );

function epic_base_writeshare_default_page() {

	return array( 'page-fullwidth.php' );
}

add_filter( 'wpws_default_page_template', 'epic_base_writeshare_default_page' );
