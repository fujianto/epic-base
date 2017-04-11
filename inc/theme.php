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

# Register custom layouts.
add_action( 'hybrid_register_layouts', 'epic_base_register_layouts' );

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
	register_nav_menu( 'primary',    esc_html_x( 'Primary',    'nav menu location', 'epic-base' ) );
}

function epic_base_default_menu() {
	$html = '<div id="primary-menu" class="collapse navbar-collapse"> <ul id="menu-all-pages" class="nav navbar-nav"> <li id="menu-item-1719" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1719"><a title="Blog" href="#">Blog</a></li> <li id="menu-item-1718" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1718"><a title="Shop" href="#">Shop</a></li> <li id="menu-item-1717" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1717"><a title="My Account" href="#">My Account</a></li> </ul> </div>';

	echo $html;
}

/**
 * Registers layouts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function epic_base_register_layouts() {

	hybrid_register_layout( '1c',   array( 'label' => esc_html__( '1 Column',                     'epic-base' ), 'image' => '%s/images/layouts/1c.png'   ) );
	hybrid_register_layout( '2c-l', array( 'label' => esc_html__( '2 Columns: Content / Sidebar', 'epic-base' ), 'image' => '%s/images/layouts/2c-l.png' ) );
	hybrid_register_layout( '2c-r', array( 'label' => esc_html__( '2 Columns: Sidebar / Content', 'epic-base' ), 'image' => '%s/images/layouts/2c-r.png' ) );
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
			'name'        => esc_html_x( 'Primary', 'sidebar', 'epic-base' ),
			'description' => esc_html__( 'Add widget to Primary sidebar.', 'epic-base' )
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'secondary',
			'name'        => esc_html_x( 'Secondary', 'sidebar', 'epic-base' ),
			'description' => esc_html__( 'Add widget to Secondary sidebar.', 'epic-base' )
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'header-right',
			'name'        => esc_html_x( 'Header Right', 'sidebar', 'epic-base' ),
			'description' => esc_html__( 'Add widget to Header right.', 'epic-base' )
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'subsidiary',
			'name'        => esc_html_x( 'Footer', 'sidebar', 'epic-base' ),
			'description' => esc_html__( 'Add widget to footer.', 'epic-base' ),
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
	wp_register_script( 'epic-base-bootstrap-script'  , EPIC_BASE_VENDOR . '/bower/bootstrap/dist/js/bootstrap.min.js', array('jquery'), null, true );
	wp_register_script( 'epic-base-radio-tabs'        , EPIC_BASE_JS     . '/radio-tabs.js', array('jquery'), null, true );
	wp_register_script( 'epic-base-main-js'           , EPIC_BASE_JS     . '/scripts.js', array('jquery'), null, true );

	/* Enqueu scripts to WordPress Footer */
	wp_enqueue_script('epic-base-bootstrap-script');
	wp_enqueue_script('epic-base-radio-tabs');
	wp_enqueue_script('epic-base-main-js');
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
	wp_enqueue_style( 'epic-base-bootstrap-epic',  EPIC_BASE_CSS   . '/customs/bootstrap-epic.css');
	wp_enqueue_style( 'epic-base-fontawesome',     EPIC_BASE_FONTS . '/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style( 'epic-base-radio-tabs',      EPIC_BASE_CSS   . '/components/radio-tabs.css');

	/* Load gallery style if 'cleaner-gallery' is active. */
	if ( current_theme_supports( 'cleaner-gallery' ) ) {
		wp_enqueue_style( 'epic-base-gallery', trailingslashit( HYBRID_CSS ) . "gallery{$suffix}.css" );
	}

	/* Load parent theme stylesheet if child theme is active. */
	if ( is_child_theme() ) {
		wp_enqueue_style( 'epic-base-parent', trailingslashit( get_template_directory_uri() ) . "style{$suffix}.css" );
	}

	/* Load active theme stylesheet. */
	wp_enqueue_style( 'epic-base-style', get_stylesheet_uri() );
}

/**
 * Add custom editor styles
 * @return void
 */
function epic_base_add_editor_styles() {
	add_editor_style( hybrid_locate_theme_file( array('css/editor-styles.css')) );
}

/**
 * Remove unused default widget
 * @return void
 */
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
	wp_register_style('open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700,300');

	wp_enqueue_style('open-sans');	
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
			<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>">
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

/**
 * Returns a set of image attachment links based on size.
 *
 * @return string
 */
function epic_base_get_image_size_links() {
	if (has_post_thumbnail()) {

		$featured_image_ID = get_post_thumbnail_id(get_the_ID());
		// Set up an empty array for the links.
		$links = array();

		// Get the intermediate image sizes and add the full size to the array.
		$sizes   = get_intermediate_image_sizes();
		$sizes[] = 'full';

		// Loop through each of the image sizes.
		foreach ( $sizes as $size ) {

			// Get the image source, width, height, and whether it's intermediate.
			$image = wp_get_attachment_image_src( $featured_image_ID, $size );

			// Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size.
			if ( ! empty( $image ) && ( true === $image[3] || 'full' == $size ) ) {

				// Translators: Media dimensions - 1 is width and 2 is height.
				$label = sprintf( esc_html__( '%1$s &#215; %2$s', 'epic-base' ), number_format_i18n( absint( $image[1] ) ), number_format_i18n( absint( $image[2] ) ) );

				$links[] = sprintf( '<a href="%s" download="%s" class="image-size-link">%s</a>', $image[0], $image[0], $label );
			}
		}

		// Join the links in a string and return.
		return join( ' <span class="sep">/</span> ', $links );
	}
}