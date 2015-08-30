<article <?php hybrid_attr( 'post' ); ?>>

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

			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<?php epic_base_entry_byline(); ?>

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-summary' ); ?>>
			<?php epic_base_get_several_gallery_thumbnail(5, '150px', '150px'); ?>
			<?php the_excerpt(); ?>
			<?php $count = hybrid_get_gallery_item_count(); ?>
			<p class="gallery-count"><?php printf( _n( 'This gallery contains %s item.', 'This gallery contains %s items.', $count, 'epic-base' ), $count ); ?></p>
		</div><!-- .entry-summary -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->