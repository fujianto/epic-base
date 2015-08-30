<?php

/* Register custom image sizes. */
add_action( 'init', 'epic_base_register_image_sizes', 5 );

/* Register custom menus. */
add_action( 'init', 'epic_base_register_menus', 5 );

/* Register sidebars. */
add_action( 'widgets_init', 'epic_base_register_sidebars', 5 );

/* Add custom scripts. */
add_action( 'wp_enqueue_scripts', 'epic_base_enqueue_scripts', 5 );

/* Add custom styles. */
add_action( 'wp_enqueue_scripts', 'epic_base_enqueue_styles', 5 );

/* Load custom font / css from CDN */
add_action('wp_print_styles'     , 'epic_base_load_fonts');

/* Add Editor style custom css for content editor */
add_action( 'init', 'epic_base_add_editor_styles' );

/* Unregister WordPress default Widget */
add_action('widgets_init', 'epic_base_unregister_widget', 1);



/**
 * Registers custom image sizes for the theme. 
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
function epic_base_register_image_sizes() {

	/* Sets the 'post-thumbnail' size. */
	//set_post_thumbnail_size( 150, 150, true );
}

/**
 * Registers nav menu locations.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
function epic_base_register_menus() {
	register_nav_menu( 'primary',    _x( 'Primary',    'nav menu location', 'epic-base' ) );
	register_nav_menu( 'secondary',  _x( 'Secondary',  'nav menu location', 'epic-base' ) );
	register_nav_menu( 'subsidiary', _x( 'Subsidiary', 'nav menu location', 'epic-base' ) );
}

/**
 * Registers sidebars.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
function epic_base_register_sidebars() {

	hybrid_register_sidebar(
		array(
			'id'          => 'primary',
			'name'        => _x( 'Primary', 'sidebar', 'epic-base' ),
			'description' => __( 'Add widget to sidebar.', 'epic-base' )
			)
		);

	hybrid_register_sidebar(
		array(
			'id'          => 'subsidiary',
			'name'        => _x( 'Subsidiary', 'sidebar', 'epic-base' ),
			'description' => __( 'Add widget to footer.', 'epic-base' ),
			'before_widget' => '<div class="sidebar footer-sidebar col-md-4 col-sm-4 col-xs-12"> <div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div></div>',
			)
		);
}

/**
 * Load scripts for the front end.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
function epic_base_enqueue_scripts() {
	/* Register the scripts to WP */
	wp_register_script( 'bootstrap-js', THEME_VENDOR . '/bower/bootstrap/dist/js/bootstrap.min.js', array('jquery'), null, true );
	wp_register_script( 'fitvids-js', THEME_VENDOR . '/bower/fitvids/jquery.fitvids.js', array('jquery'), null, true );
	wp_register_script( 'radio-tabs', THEME_JS . '/radio-tabs.js', array('jquery'), null, true );
	wp_register_script( 'main-js', THEME_JS . '/scripts.js', array('jquery', 'fitvids-js'), null, true );
	/* Enqueu scripts to WordPress Footer */
	wp_enqueue_script('bootstrap-js');
	wp_enqueue_script('radio-tabs');
	wp_enqueue_script('main-js');
}

/**
 * Load stylesheets for the front end.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
function epic_base_enqueue_styles() {

	/* Gets ".min" suffix. */
	$suffix = hybrid_get_min_suffix();

	/* Customized Bootstrap Css*/
	wp_enqueue_style( 'bootstrap-epic',  THEME_CSS   . '/customs/bootstrap-epic.css');
	wp_enqueue_style( 'flexslider-epic', THEME_CSS   . '/components/flexslider-epic.css');
	wp_enqueue_style( 'fontawesome',     THEME_FONTS . '/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style( 'radio-tabs',      THEME_CSS   . '/components/radio-tabs.css');
	wp_enqueue_style( 'global',      	 THEME_CSS   . '/global.css');

	/* Load gallery style if 'cleaner-gallery' is active. */
	if ( current_theme_supports( 'cleaner-gallery' ) ) {
		wp_enqueue_style( 'gallery', trailingslashit( HYBRID_CSS ) . "gallery{$suffix}.css" );
	}

	/* Load parent theme stylesheet if child theme is active. */
	if ( is_child_theme() ) {
		wp_enqueue_style( 'parent', trailingslashit( get_template_directory_uri() ) . "style{$suffix}.css" );
	}

	/* Load active theme stylesheet. */
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}

// function epic_base_enqueue_admin_styles(){
// 	wp_enqueue_style( 'fontawesome-admin' , THEME_FONTS. '/font-awesome/css/font-awesome.min.css');
// 	wp_enqueue_style( 'caviar-styles'     , THEME_VENDOR . '/caviar/css/admin-styles.css');
// 	wp_enqueue_style( 'radiotabs-admin'   , THEME_VENDOR . '/caviar/css/radio-tabs.css');
// }

// function epic_base_enqueue_admin_scripts(){
// 	wp_register_script( 'radiotabs-admin-js', THEME_VENDOR.'/caviar/js/radio-tabs.js', array('jquery'), null, true);
// 	wp_register_script( 'caviar-admin-js', THEME_VENDOR.'/caviar/js/admin-scripts.js', array('jquery', 'radiotabs-admin-js', 'wp-color-picker'), null, true);

// 	wp_enqueue_script('caviar-admin-js');
// }

// function epic_base_add_color_picker( $hook ) {

// 	if( is_admin() ) { 
//     // Add the color picker css file       
// 		wp_enqueue_style( 'wp-color-picker' ); 

//   //   // Include our custom jQuery file with WordPress Color Picker dependency
// 		// wp_enqueue_script( 'custom-script-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
// 	}
// }

/**
 * Add custom editor styles
 * @return void
 */
function epic_base_add_editor_styles() {
	add_editor_style( hybrid_locate_theme_file( array('css/editor-styles.css')) );
}

function epic_base_unregister_widget() {
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	// unregister_widget('WP_Widget_Categories');
}

/**
 * Load custom font / css from CDN
 * @return Void
 */
function epic_base_load_fonts(){
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700,300');

	wp_enqueue_style('googleFonts');	
}

/**
 * [epic_base_entry_col_width description]
 * @return string entry wrapper class
 */
function epic_base_entry_col_width(){
	$class = '';
	/* If one column layout choosen, .col-md-12 will be added to entry-wrapper */
	if ('1c' === get_theme_mod( 'theme_layout' ) ) {
		return 'col-md-12';
	} else{
		return 'col-md-8';
	}
}

/**
 * Get several images from post format gallery and show it on home / index.
 * 
 * @param int $images_count Number of images that would be displayed.
 * @param string $size Size of image attachment, default size is medium. (thumbnail, small, medium, large).
 * 
 * @return mixed
 */
function epic_base_get_several_gallery_thumbnail($images_count = 3, $width = '372px', $height = '200px'){
	/* Check if Gallery exist inside post */
	if ( get_post_gallery() ) :
		$gallery = get_post_gallery( get_the_ID(), false );

	echo "<div class='caviar_gallery'>";

	$i = 1;
	/* Loop through all the image and output them one by one */
	foreach( $gallery['src'] AS $src )
	{ 
		?>

		<figure class="caviar_item">
			<a href="<?php echo get_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<img src="<?php echo $src; ?>" class="caviar_img" alt="<?php the_title_attribute(); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"/>
			</a>
		</figure>


		<?php
		/* $images_count = How many image will be shown	*/
		if ($i++ == $images_count) 
			break;
	}

	echo "</div>";

	endif;			
}

/**
 * Include all files inside directory
 * @param  string $directory Path of directory
 * @return void
 */
function epic_base_load_all_php($directory){
	foreach (glob("{$directory}/*.php") as $filename){
		require_once $filename;
	}
}

function epic_base_admin_scripts(){
	wp_register_script( 'repeater-js', THEME_VENDOR . '/bower/jquery.repeater/jquery.repeater.min.js', array('jquery'), null, true );
	wp_register_script( 'admin-js', THEME_JS . '/admin-script.js', array('jquery', 'repeater-js'), null, true );

	wp_enqueue_script('admin-js');
}

add_action('admin_enqueue_scripts', 'epic_base_admin_scripts' );