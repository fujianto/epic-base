<li <?php hybrid_attr( 'comment' ); ?>>

	<article class="comment-wrap">
		<div class="comment-avatar u-pull-left">
			<?php echo get_avatar( $comment, 46);  ?>
		</div>

		<header class="comment-meta">
			<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite><br />
			<time <?php hybrid_attr( 'comment-published' ); ?>><?php esc_html_e( "On", "epic-base" ); ?> <?php echo get_the_date(); ?></time>
			<a <?php hybrid_attr( 'comment-permalink' ); ?>><?php esc_html_e( 'Permalink', 'epic-base' ); ?></a>
			<?php edit_comment_link(); ?>
		</header><!-- .comment-meta -->

		<div <?php hybrid_attr( 'comment-content' ); ?>>
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<?php hybrid_comment_reply_link(); ?>
	</article>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>