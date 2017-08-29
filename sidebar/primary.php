<?php
/**
 * Sidebar primary beside main content
 *
 * @package    Epic Base
 * @subpackage sidebar
 */

?>

<?php if ( '1c' !== hybrid_get_theme_layout() ) : ?>

	<aside <?php hybrid_attr( 'sidebar', 'primary' ); ?>>

		<?php if ( is_active_sidebar( 'primary' ) ) : ?>

			<?php dynamic_sidebar( 'primary' ); ?>

		<?php else : ?>

			<?php
			the_widget(
				'WP_Widget_Text',
				array(
					'title'  => esc_html__( 'Example Widget', 'epic-base' ),
					'text'   => sprintf( esc_html__( 'This is an example widget to show how the Primary sidebar looks by default. You can add custom widgets from the widgets screen in the admin.', 'epic-base' ), current_user_can( 'edit_theme_options' ) ? '<a href="' . admin_url( 'widgets.php' ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
					'filter' => true,
				),
				array(
					'before_widget' => '<section class="widget widget_text">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				)
			);
			?>

		<?php endif; ?>

	</aside><!-- #sidebar-primary -->

<?php endif; ?>
