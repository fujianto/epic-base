<?php
/**
 * Content for comment error.
 *
 * @package    Epic Base
 * @subpackage template parts
 */

?>

<?php if ( pings_open() && ! comments_open() ) : ?>

	<p class="comments-closed pings-open">
		<?php
			/* Translators: The two  are placeholders for HTML. The order can't be changed. */
			printf( esc_html__( 'Comments are closed, but trackbacks and pingbacks are open.', 'epic-base' ), '<a href="' . esc_url( get_trackback_url() ) . '">', '</a>' );
		?>
	</p><!-- .comments-closed .pings-open -->

<?php elseif ( ! comments_open() ) : ?>

	<p class="comments-closed">
		<?php esc_attr_e( 'Comments are closed.', 'epic-base' ); ?>
	</p><!-- .comments-closed -->

<?php endif; ?>
