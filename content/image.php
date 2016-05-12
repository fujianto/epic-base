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

			<div class="entry-byline">
				<span class="image-sizes"><?php printf( esc_html__( 'Image Sizes: %s', 'epic-base' ), epic_base_get_image_size_links() ); ?></span>
			</div><!-- .entry-byline -->

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

<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post. ?>

	<div class="media-info image-info">

		<h3 class="attachment-meta-title"><?php esc_html_e( 'Image Info', 'epic-base' ); ?></h3>
		
		<?php $featured_image_ID = get_post_thumbnail_id(get_the_ID()); ?>

		<ul class="media-meta">
			<?php $pre = '<li><span class="prep">%s</span>'; ?>
			<?php hybrid_media_meta( 'dimensions',        array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Dimensions',    'epic-base' ) ), 'after' => '</li>' ) ); ?>
			<?php hybrid_media_meta( 'created_timestamp', array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Date',          'epic-base' ) ), 'after' => '</li>' ) ); ?>
			<?php hybrid_media_meta( 'camera',            array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Camera',        'epic-base' ) ), 'after' => '</li>' ) ); ?>
			<?php hybrid_media_meta( 'aperture',          array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Aperture',      'epic-base' ) ), 'after' => '</li>' ) ); ?>
			<?php hybrid_media_meta( 'focal_length',      array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Focal Length',  'epic-base' ) ), 'after' => '</li>', 'text' => esc_html__( '%s mm', 'epic-base' ) ) ); ?>
			<?php hybrid_media_meta( 'iso',               array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'ISO',           'epic-base' ) ), 'after' => '</li>' ) ); ?>
			<?php hybrid_media_meta( 'shutter_speed',     array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Shutter Speed', 'epic-base' ) ), 'after' => '</li>', 'text' => esc_html__( '%s sec', 'epic-base' ) ) ); ?>
			<?php hybrid_media_meta( 'file_type',         array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Type',          'epic-base' ) ), 'after' => '</li>' ) ); ?>
			<?php hybrid_media_meta( 'file_name',         array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Name',          'epic-base' ) ), 'after' => '</li>' ) ); ?>
			<?php hybrid_media_meta( 'mime_type',         array( 'post_id' => $featured_image_ID, 'before' => sprintf( $pre, esc_html__( 'Mime Type',     'epic-base' ) ), 'after' => '</li>' ) ); ?>
		</ul>

	</div><!-- .media-info -->

<?php endif; // End single post check. ?>