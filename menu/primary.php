<?php use Webcode\WordPress\Template\BootstrapNavWalker; ?>

<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>
	<div class="primary-nav-menu">
		<div class="row">
			<nav class="navbar navbar-default" <?php hybrid_attr( 'menu', 'primary' ); ?>>
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-menu">
						<span class="sr-only">Toggle navigation</span>
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
							'menu'              => 'primary',
							'theme_location'    => 'primary',
							'depth'             => 2,
							'container'         => 'div',
							'container_class'   => 'collapse navbar-collapse',
							'container_id'      => 'primary-menu',
							'menu_class'        => 'nav navbar-nav',
							'fallback_cb'       => 'BootstrapNavWalker::fallback',
							'walker'            => new BootstrapNavWalker()
						)
					); ?>
			</nav>
		</div>
	</div>
	<!-- End primary-nav-men  -->
<?php endif; // End check for menu. ?>