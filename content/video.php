<article <?php hybrid_attr( 'post' ); ?>>
	
	<div class="featured embed-wrap">
		<?php echo ( $video = hybrid_media_grabber( array( 'type' => 'video', 'split_media' => true ) ) ); ?>
	</div>
	
	<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post. ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

			<?php epic_base_entry_byline(); ?>

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<?php epic_base_entry_footer(); ?>

	<?php else : // If not viewing a single post. ?>

		<header class="entry-header">

			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . esc_url(get_permalink()) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<?php epic_base_entry_byline(); ?>

		</header><!-- .entry-header -->

		<?php if ( has_excerpt() ) : // If the post has an excerpt. ?>

			<div <?php hybrid_attr( 'entry-summary' ); ?>>
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

		<?php elseif ( empty( $video ) ) : // Else, if the post does not have a video. ?>

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<?php the_content(); ?>
			</div><!-- .entry-content -->

		<?php endif; // End excerpt/video checks. ?>

	<?php endif; // End single post check. ?>

</article><!-- .entry -->