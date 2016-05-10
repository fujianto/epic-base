<article <?php hybrid_attr( 'post' ); ?>>

	<div class="featured image">
		
		<?php if(has_post_thumbnail()) : ?>
			<!-- Try to get the image from post thumnail or else get the first image using get_the_image() -->
			<?php echo get_the_post_thumbnail(); ?>

			<!-- @TODO: Try to hide images on Post, find a way to do it gracefully -->
			<?php get_the_image( array( 'echo' => false, 'size' => 'full', 'split_content' => true, 'scan_raw' => true, 'scan' => true, 'order' => array( 'scan_raw', 'scan', 'featured', 'attachment' ) ) ); ?>

		<?php else: ?>

			<?php get_the_image( array( 'echo' => true, 'size' => 'full', 'split_content' => true, 'scan_raw' => true, 'scan' => true, 'order' => array( 'scan_raw', 'scan', 'featured', 'attachment' ) ) ); ?>

		<?php endif; ?>


	</div>

	<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post. ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

			<?php epic_base_entry_byline(); ?>

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>

			<?php if (has_post_thumbnail()) : ?>
				<?php
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
							$label = sprintf( esc_html__( '%1$s &#215; %2$s', 'hybrid-core' ), number_format_i18n( absint( $image[1] ) ), number_format_i18n( absint( $image[2] ) ) );

							$links[] = sprintf( '<a href="%s" class="image-size-link">%s</a>', $image[0], $label );
						}
					}

					// Join the links in a string and return.
					echo join( ' <span class="sep">/</span> ', $links );

				?>
			<?php endif; ?>

		</div><!-- .entry-content -->

		<?php epic_base_entry_footer(); ?>

	<?php else : // If not viewing a single post. ?>

		<header class="entry-header">

			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<?php epic_base_entry_byline(); ?>

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-summary' ); ?>>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->