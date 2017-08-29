<?php
/**
 * Menu primary
 *
 * @package    Epic Base
 * @subpackage menu
 */

?>

<?php if ( class_exists( 'wp_bootstrap_navwalker' ) ) : ?>	

	<div class="primary-nav-menu">
		<div class="row">
			<nav class="navbar navbar-default" <?php hybrid_attr( 'menu', 'primary' ); ?>>
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-menu">
						<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'epic-base' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- <a class="navbar-brand" href="#">Brand</a> -->
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<?php
					wp_nav_menu(
						array(
							'theme_location'    => 'primary',
							'depth'             => 2,
							'container'         => 'div',
							'container_class'   => 'collapse navbar-collapse',
							'container_id'      => 'primary-menu',
							'menu_class'        => 'nav navbar-nav',
							'fallback_cb'       => 'wp_page_menu',
							'walker'            => new wp_bootstrap_navwalker(),
						)
					);
					?>
			</nav>
		</div>
	</div>
	<!-- End primary-nav-men  -->

<?php endif; ?>
