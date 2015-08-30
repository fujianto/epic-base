<?php
/* Define Constant */
define( 'THEME_VENDOR_DIR'  , get_template_directory() . '/vendor'        );
define( 'THEME_URI'         , get_template_directory_uri() );
define( 'THEME_IMAGES'      , THEME_URI . '/images'        );
define( 'THEME_CSS'         , THEME_URI . '/css'           );
define( 'THEME_JS'          , THEME_URI . '/js'            );
define( 'THEME_FONTS'       , THEME_URI . '/fonts'         );
define( 'THEME_VENDOR'      , THEME_URI . '/vendor'        );

/* Initialize required files  */
require_once( THEME_VENDOR_DIR . '/caviar/class-form-controls.php' );

/* Enable media library */
add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );

/* Add custom Admin styles. */
add_action( 'admin_enqueue_scripts', 'caviar_enqueue_admin_styles' );

/* Add custom Admin scripts. */
add_action( 'admin_enqueue_scripts', 'caviar_enqueue_admin_scripts' );

/* Add the color picker css file */       
add_action( 'admin_enqueue_scripts', 'caviar_add_color_picker' );


function caviar_enqueue_admin_styles(){
	wp_enqueue_style( 'fontawesome-admin' , THEME_FONTS. '/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style( 'caviar-styles'     , THEME_VENDOR . '/caviar/css/admin-styles.css');
	wp_enqueue_style( 'radiotabs-admin'   , THEME_VENDOR . '/caviar/css/radio-tabs.css');

	wp_enqueue_style('jquery-ui');
}

function caviar_enqueue_admin_scripts(){
	wp_register_script( 'cloneya-js'         , THEME_VENDOR.'/caviar/vendor/bower/cloneya/dist/jquery-cloneya.min.js', array('jquery'), null, true);
	wp_register_script( 'radiotabs-admin-js' , THEME_VENDOR.'/caviar/js/radio-tabs.js', array('jquery'), null, true);
	wp_register_script( 'caviar-admin-js'    , THEME_VENDOR.'/caviar/js/admin-scripts.js', array('jquery', 'radiotabs-admin-js', 'wp-color-picker', 'cloneya-js'), null, true);

	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-tabs');

	wp_enqueue_script('caviar-admin-js');
}

function caviar_add_color_picker( $hook ) {

	if( is_admin() ) { 
    // Add the color picker css file       
		wp_enqueue_style( 'wp-color-picker' ); 

    // Include our custom jQuery file with WordPress Color Picker dependency
		// wp_enqueue_script( 'custom-script-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
	}
}