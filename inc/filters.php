<?php

/**
 * Filter to add extra class to <body> tag.
 * @param  String $classes Array of available class
 * @return [type]          [description]
 */
function epic_base_body_class( $classes ){
	/* Set default layout to fluid by adding class to body */
	$classes[] = 'fluid';	

	return $classes;
}

/* Add extra class to body */
add_filter( 'body_class', 'epic_base_body_class' );

/**
 * Filter to add extra attribute to Site Title
 * @param  String $attr Site title attribute 
 * @return Array  Attribute of Site Title
 */
function epic_base_attr_site_title( $attr ){
	$attr['class'] = 'site-title';

	return $attr;
}

/* Add extra class to Site title */
add_filter('hybrid_attr_site-title', 'epic_base_attr_site_title');

function epic_base_attr_header( $attr ){
	$attr['class'] = 'header';

	return $attr;
}

add_filter('hybrid_attr_header', 'epic_base_attr_header');

/**
 * Add extra class on site description
 * @param  array $attr [description]
 * @return array       [description]
 */
function epic_base_site_description( $attr ){
	$attr['class'] = 'site-description';

	return $attr;
}

add_filter('hybrid_attr_site-description', 'epic_base_site_description');

/**
 * Add custom attribute to sidebar based on sidebar name
 * @param  array $attr    [description]
 * @param  [type] $context [description]
 * @return array         [description]
 */
function epic_base_attr_sidebar( $attr, $context ){
	$sidebar_name = hybrid_get_sidebar_name( $context );

	if( $sidebar_name === 'Primary') {
		if ('2c-r' === hybrid_get_theme_layout() ) {
			$attr['class'] = $attr['class']. ' col-md-4 col-md-pull-8';
		} else {
			$attr['class'] = $attr['class']. ' col-md-4';
		}	
	}

	return $attr;
}

add_filter('hybrid_attr_sidebar', 'epic_base_attr_sidebar',  10, 2);

/**
 * Add extra class on footer
 * 
 * @param  array $attr [description]
 * @return [type]       [description]
 */
function epic_base_attr_footer($attr){
	$attr['class'] = 'footer-wrapper';

	return $attr;
}

add_action( 'hybrid_attr_footer', 'epic_base_attr_footer' );

/**
 * Add extra class to entry summary
 * @param  array $attr [description]
 * @return array
 */
function epic_base_attr_entry_summary( $attr ) {
	$attr['class']    = $attr['class'].' clearfix';

	return $attr;
}

add_action('hybrid_attr_entry-summary', 'epic_base_attr_entry_summary');


/**
 * Filter for Post <article> element attributes.
 * @param  array   $attr
 * 
 * @return array
 */
function epic_base_attr_post( $attr ){
	if( has_post_format('status') ){
		$attr['class']    = $attr['class'].' clearfix';
	}

	return $attr;
}

add_action('hybrid_attr_post', 'epic_base_attr_post');