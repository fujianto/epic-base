<?php if ( is_singular( 'post' ) ) : // If viewing a single post page. ?>

	<div class="loop-nav clearfix">
		<?php previous_post_link( '<div class="prev pull-left">' . esc_html__( '&laquo; Previous Post: %link', 'epic-base' ) . '</div>', '%title' ); ?>
		<?php next_post_link(     '<div class="next pull-right">' . esc_html__( 'Next Post: %link &raquo;',     'epic-base' ) . '</div>', '%title' ); ?>
	</div><!-- .loop-nav -->

<?php elseif ( is_home() || is_archive() || is_search() ) : // If viewing the blog, an archive, or search results. ?>

	<?php epic_base_main_pagination(); //Pagination for post / page archives ?>

<?php endif; // End check for type of page being viewed. ?>