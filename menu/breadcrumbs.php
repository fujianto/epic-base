<?php if ( function_exists( 'breadcrumb_trail' ) ) : // Check for breadcrumb support. ?>

	<?php breadcrumb_trail(
		array( 
			'container'     => 'nav',
			'show_on_front' => false,
			'separator' => '/',
			'labels'        => array( 
				'browse' => __( 'You are here:', 'epic-base' ) 
			) 
		) 
	); ?>

<?php endif; // End check for breadcrumb support. ?>