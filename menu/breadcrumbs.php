<?php if ( function_exists('yoast_breadcrumb') ) :
	yoast_breadcrumb('<p id="breadcrumbs">','</p>');
?>
<?php elseif ( function_exists( 'breadcrumb_trail' ) ) : // Check for breadcrumb support. ?>

	<?php breadcrumb_trail(
		array( 
			'container'     => 'nav', 
			'separator'     => '/', 
			'show_on_front' => true,

			'labels'        => array( 
				'browse' => __( 'You are here:', 'citrusBase' ) 
			) 
		) 
	); ?>

<?php endif; // End check for breadcrumb support. ?>