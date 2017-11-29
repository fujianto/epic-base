<?php
/**
 * Sidebar subsdiary below main content
 *
 * @package    Epic Base
 * @subpackage sidebar
 */

?>

<?php if ( is_active_sidebar( 'subsidiary' ) ) : ?>

	<aside <?php hybrid_attr( 'sidebar', 'subsidiary' ); ?>>
	
		<div class="row">
			<?php dynamic_sidebar( 'subsidiary' ); ?>
		</div>

	</aside><!-- #sidebar-subsidiary -->

<?php endif; ?>
