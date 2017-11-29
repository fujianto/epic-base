<article <?php hybrid_attr( 'post' ); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Nothing found', 'epic-base' ); ?></h1>
	</header><!-- .entry-header -->

	<div <?php hybrid_attr( 'entry-content' ); ?>>
		<?php echo wpautop( esc_html__( 'Apologies, but no entries were found.', 'epic-base' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- .entry -->
